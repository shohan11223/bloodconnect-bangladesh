<?php

namespace App\Http\Requests\Ambulance;

use Illuminate\Foundation\Http\FormRequest;

class StoreAmbulanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ambulance_name' => 'required|string|max:255',
            'vehicle_number' => 'required|string|unique:ambulances|max:50',
            'owner_name' => 'required|string|max:255',
            'driver_name' => 'required|string|max:255',
            'driver_mobile' => 'required|regex:/^(?:\+880|880|0)?\d{10}$/',
            'driver_license' => 'nullable|string|max:50',
            'division' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'upazila' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'per_kilometer_fare' => 'required|numeric|min:0|max:10000',
            'base_fare' => 'nullable|numeric|min:0|max:10000',
            'ambulance_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'vehicle_number.unique' => 'এই গাড়ির নম্বর ইতিমধ্যে রয়েছে',
            'per_kilometer_fare.required' => 'প্রতি কিলোমিটার ভাড়া নির্ধারণ করুন',
        ];
    }
}