<?php

namespace App\Http\Requests\BloodRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreBloodRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_name' => 'required|string|max:255',
            'blood_group' => 'required|in:O+,O-,A+,A-,B+,B-,AB+,AB-',
            'hemoglobin' => 'nullable|numeric|min:0|max:20',
            'quantity_needed' => 'required|integer|min:1|max:100',
            'hospital_name' => 'required|string|max:255',
            'room_number' => 'required|string|max:50',
            'blood_donation_location' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'upazila' => 'nullable|string|max:255',
            'emergency_contact_number' => 'required|regex:/^(?:\+880|880|0)?\d{10}$/',
            'required_date_time' => 'required|date_format:Y-m-d H:i|after:now',
            'special_notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'blood_group.required' => 'রক্তের গ্রুপ নির্বাচন করুন',
            'quantity_needed.required' => 'প্রয়োজনীয় ব্যাগের সংখ্যা লিখুন',
            'required_date_time.after' => 'ভবিষ্যতের তারিখ নির্বাচন করুন',
        ];
    }
}
