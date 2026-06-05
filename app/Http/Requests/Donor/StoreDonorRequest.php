<?php

namespace App\Http\Requests\Donor;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Personal Information
            'full_name' => 'required|string|max:255',
            'blood_group' => 'required|in:O+,O-,A+,A-,B+,B-,AB+,AB-',
            'hemoglobin_level' => 'nullable|numeric|min:0|max:20',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            // Permanent Address
            'permanent_division' => 'required|string|max:255',
            'permanent_district' => 'required|string|max:255',
            'permanent_upazila' => 'nullable|string|max:255',
            'permanent_union' => 'nullable|string|max:255',
            'permanent_ward' => 'nullable|string|max:255',
            'permanent_address' => 'required|string|max:500',

            // Present Address
            'present_division' => 'required|string|max:255',
            'present_district' => 'required|string|max:255',
            'present_upazila' => 'nullable|string|max:255',
            'present_union' => 'nullable|string|max:255',
            'present_ward' => 'nullable|string|max:255',
            'present_address' => 'required|string|max:500',

            // Contact
            'mobile_number' => 'required|regex:/^(?:\+880|880|0)?\d{10}$/',
            'emergency_mobile_number' => 'required|regex:/^(?:\+880|880|0)?\d{10}$/',
            'whatsapp_number' => 'nullable|regex:/^(?:\+880|880|0)?\d{10}$/',
            'gmail_address' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'blood_group.required' => 'রক্তের গ্রুপ নির্বাচন করুন',
            'mobile_number.regex' => 'বাংলাদেশের বৈধ মোবাইল নম্বর প্রদান করুন',
            'date_of_birth.before' => 'জন্মতারিখ আজকের আগে হতে হবে',
        ];
    }
}