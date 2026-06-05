<?php

namespace App\Actions;

use App\Models\Receiver;
use App\Models\User;
use Illuminate\Support\Str;

class CreateTemporaryReceiverAction
{
    public function execute(array $data): Receiver
    {
        $receiverToken = Str::uuid();

        // Create temporary user if not logged in
        $user = auth()->user();
        
        if (!$user) {
            $user = User::create([
                'name' => $data['patient_name'],
                'email' => "receiver_{$receiverToken}@bloodconnect.bd",
                'password' => bcrypt(Str::random(32)),
                'phone' => $data['emergency_contact_number'],
                'role' => 'receiver',
            ]);
        }

        $receiver = Receiver::create([
            'user_id' => $user->id,
            'receiver_token' => $receiverToken,
            'patient_name' => $data['patient_name'],
            'blood_group' => $data['blood_group'],
            'hemoglobin' => $data['hemoglobin'] ?? null,
            'quantity_needed' => $data['quantity_needed'],
            'hospital_name' => $data['hospital_name'],
            'room_number' => $data['room_number'],
            'blood_donation_location' => $data['blood_donation_location'],
            'division' => $data['division'],
            'district' => $data['district'],
            'upazila' => $data['upazila'] ?? null,
            'emergency_contact_number' => $data['emergency_contact_number'],
            'required_date_time' => $data['required_date_time'],
            'status' => 'active',
            'special_notes' => $data['special_notes'] ?? null,
            'expires_at' => now()->addHours(24),
        ]);

        return $receiver;
    }
}