<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ambulance;
use Illuminate\Http\JsonResponse;

class AmbulanceController extends Controller
{
    public function index(): JsonResponse
    {
        $ambulances = Ambulance::where('approval_status', 'admin_approved')
            ->where('is_verified', true)
            ->paginate(15);

        return response()->json($ambulances);
    }

    public function show(Ambulance $ambulance): JsonResponse
    {
        if (!$ambulance->isApproved()) {
            return response()->json(['message' => 'অনুপলব্ধ'], 404);
        }

        return response()->json($ambulance);
    }

    public function search($division, $district): JsonResponse
    {
        $ambulances = Ambulance::where('division', $division)
            ->where('district', $district)
            ->where('approval_status', 'admin_approved')
            ->where('is_verified', true)
            ->where('availability_status', '!=', 'inactive')
            ->get(['id', 'ambulance_name', 'vehicle_number', 'driver_mobile', 
                   'per_kilometer_fare', 'base_fare', 'availability_status']);

        return response()->json($ambulances);
    }

    public function updateStatus(Ambulance $ambulance, $status): JsonResponse
    {
        $this->authorize('update', $ambulance);

        if (!in_array($status, ['available', 'occupied', 'maintenance', 'inactive'])) {
            return response()->json(['message' => 'অবৈধ স্থিতি'], 422);
        }

        $ambulance->update(['availability_status' => $status]);

        return response()->json(['message' => 'স্থিতি আপডেট হয়েছে'], 200);
    }
}