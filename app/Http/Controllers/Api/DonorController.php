<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Http\Requests\Donor\StoreDonorRequest;
use Illuminate\Http\JsonResponse;

class DonorController extends Controller
{
    public function index(): JsonResponse
    {
        $donors = Donor::where('account_status', 'verified')
            ->where('eligibility_status', 'eligible')
            ->paginate(15);

        return response()->json($donors);
    }

    public function show(Donor $donor): JsonResponse
    {
        if ($donor->account_status !== 'verified') {
            return response()->json(['message' => 'অননুমোদিত অ্যাক্সেস'], 403);
        }

        return response()->json($donor);
    }

    public function searchByBloodGroup($bloodGroup): JsonResponse
    {
        $donors = Donor::where('blood_group', $bloodGroup)
            ->where('account_status', 'verified')
            ->where('eligibility_status', 'eligible')
            ->get(['id', 'donor_id', 'blood_group', 'mobile_number', 'present_district']);

        return response()->json($donors);
    }

    public function searchByLocation($division, $district): JsonResponse
    {
        $donors = Donor::where('present_division', $division)
            ->where('present_district', $district)
            ->where('account_status', 'verified')
            ->where('eligibility_status', 'eligible')
            ->get();

        return response()->json($donors);
    }
}