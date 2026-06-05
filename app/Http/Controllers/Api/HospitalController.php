<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use Illuminate\Http\JsonResponse;

class HospitalController extends Controller
{
    public function index(): JsonResponse
    {
        $hospitals = Hospital::where('approval_status', 'admin_approved')
            ->where('is_verified', true)
            ->paginate(15);

        return response()->json($hospitals);
    }

    public function show(Hospital $hospital): JsonResponse
    {
        if (!$hospital->isApproved()) {
            return response()->json(['message' => 'অনুপলব্ধ'], 404);
        }

        return response()->json($hospital);
    }

    public function search($division, $district): JsonResponse
    {
        $hospitals = Hospital::where('division', $division)
            ->where('district', $district)
            ->where('approval_status', 'admin_approved')
            ->where('is_verified', true)
            ->get(['id', 'hospital_id', 'hospital_name', 'hospital_type', 
                   'phone_number', 'has_icu', 'has_blood_bank', 'emergency_contact']);

        return response()->json($hospitals);
    }

    public function byType($type): JsonResponse
    {
        $hospitals = Hospital::where('hospital_type', $type)
            ->where('approval_status', 'admin_approved')
            ->where('is_verified', true)
            ->get();

        return response()->json($hospitals);
    }
}