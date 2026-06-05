<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BloodRequest\StoreBloodRequestRequest;
use App\Models\BloodRequest;
use App\Models\Receiver;
use App\Jobs\NotifyMatchingDonorsJob;
use Illuminate\Http\JsonResponse;

class BloodRequestController extends Controller
{
    public function index(): JsonResponse
    {
        $requests = BloodRequest::with('receiver')
            ->where('status', '!=', 'cancelled')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json($requests);
    }

    public function show(BloodRequest $bloodRequest): JsonResponse
    {
        return response()->json($bloodRequest->load('receiver', 'responses'));
    }

    public function store(StoreBloodRequestRequest $request): JsonResponse
    {
        $receiver = Receiver::findOrFail($request->receiver_id);

        $bloodRequest = BloodRequest::create([
            'receiver_id' => $receiver->id,
            'blood_group' => $receiver->blood_group,
            'quantity_needed' => $receiver->quantity_needed,
            'description' => $request->special_notes ?? '',
            'required_date_time' => $receiver->required_date_time,
            'expires_at' => now()->addHours(24),
            'is_emergency' => true,
        ]);

        // Dispatch job to notify matching donors
        dispatch(new NotifyMatchingDonorsJob($bloodRequest));

        return response()->json($bloodRequest, 201);
    }

    public function accept(BloodRequest $bloodRequest): JsonResponse
    {
        $this->authorize('accept', $bloodRequest);

        if ($bloodRequest->status !== 'pending') {
            return response()->json(['message' => 'অনুরোধ গ্রহণযোগ্য নয়'], 422);
        }

        $donor = auth()->user()->donor;

        // Check if already accepted
        $existing = $bloodRequest->responses()
            ->where('donor_id', $donor->id)
            ->exists();

        if ($existing) {
            return response()->json(['message' => 'আপনি ইতিমধ্যে এই অনুরোধ গ্রহণ করেছেন'], 422);
        }

        $bloodRequest->responses()->create([
            'donor_id' => $donor->id,
            'status' => 'accepted',
        ]);

        $bloodRequest->increment('accepted_count');

        return response()->json(['message' => 'রক্তের অনুরোধ সফলভাবে গ্রহণ করা হয়েছে'], 200);
    }

    public function markFulfilled(BloodRequest $bloodRequest): JsonResponse
    {
        $this->authorize('update', $bloodRequest);

        if ($bloodRequest->isFulfilled()) {
            $bloodRequest->update(['status' => 'fulfilled', 'fulfilled_at' => now()]);
            return response()->json(['message' => 'অনুরোধ পূরণ করা হয়েছে'], 200);
        }

        return response()->json(['message' => 'পর্যাপ্ত রক্ত সংগ্রহ করা হয়নি'], 422);
    }
}