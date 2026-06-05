<?php

namespace App\Actions;

use App\Models\Donor;
use App\Models\User;
use Illuminate\Support\Str;

class RegisterDonorAction
{
    public function execute(array $data): Donor
    {
        $user = User::create([
            'name' => $data['full_name'],
            'email' => $data['gmail_address'],
            'password' => bcrypt($data['password']),
            'phone' => $data['mobile_number'],
            'role' => 'donor',
        ]);

        $donor = Donor::create([
            'user_id' => $user->id,
            'donor_id' => $this->generateDonorId(),
            'blood_group' => $data['blood_group'],
            'hemoglobin_level' => $data['hemoglobin_level'] ?? null,
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'],
            'profile_photo' => $data['profile_photo'] ?? null,
            'permanent_division' => $data['permanent_division'],
            'permanent_district' => $data['permanent_district'],
            'permanent_upazila' => $data['permanent_upazila'] ?? null,
            'permanent_union' => $data['permanent_union'] ?? null,
            'permanent_ward' => $data['permanent_ward'] ?? null,
            'permanent_address' => $data['permanent_address'],
            'present_division' => $data['present_division'],
            'present_district' => $data['present_district'],
            'present_upazila' => $data['present_upazila'] ?? null,
            'present_union' => $data['present_union'] ?? null,
            'present_ward' => $data['present_ward'] ?? null,
            'present_address' => $data['present_address'],
            'mobile_number' => $data['mobile_number'],
            'emergency_mobile_number' => $data['emergency_mobile_number'],
            'whatsapp_number' => $data['whatsapp_number'] ?? null,
            'gmail_address' => $data['gmail_address'],
            'account_status' => 'pending',
            'eligibility_status' => 'pending_review',
        ]);

        return $donor;
    }

    private function generateDonorId(): string
    {
        $prefix = 'BD';
        $timestamp = now()->format('YmdHis');
        $random = Str::random(4);
        
        return "{$prefix}{$timestamp}{$random}";
    }
}