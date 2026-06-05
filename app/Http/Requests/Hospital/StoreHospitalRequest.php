<?php

namespace App\Http\Requests\Hospital;

use Illuminate\Foundation\Http\FormRequest;

class StoreHospitalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hospital_name' => 'required|string|max:255',
            'license_number' => 'required|string|unique:hospitals|max:50',
            'hospital_type' => 'required|in:government,private,ngo,military',
            'division' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'upazila' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'emergency_contact' => 'required|string|max:255',
            'phone_number' => 'required|regex:/^(?:\+880|880|0)?\d{10}$/',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'has_ambulance_support' => 'boolean',
            'has_icu' => 'boolean',
            'icu_beds' => 'nullable|integer|min:0|max:1000',
            'has_blood_bank' => 'boolean',
            'blood_bank_details' => 'nullable|string|max:1000',
            'hospital_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'license_number.unique' => 'এই লাইসেন্স নম্বর ইতিমধ্যে রয়েছে',
            'hospital_type.required' => 'হাসপাতালের ধরন নির্বাচন করুন',
        ];
    }
}