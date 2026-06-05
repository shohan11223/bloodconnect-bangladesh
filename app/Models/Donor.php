<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Donor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'donor_id', 'blood_group', 'hemoglobin_level', 'date_of_birth', 'gender', 'profile_photo',
        'permanent_division', 'permanent_district', 'permanent_upazila', 'permanent_union', 'permanent_ward', 'permanent_address',
        'present_division', 'present_district', 'present_upazila', 'present_union', 'present_ward', 'present_address',
        'mobile_number', 'emergency_mobile_number', 'whatsapp_number', 'gmail_address',
        'account_status', 'email_verified', 'whatsapp_verified', 'last_donation_date', 'donation_count',
        'eligibility_status', 'ineligibility_reason'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'last_donation_date' => 'datetime',
        'email_verified' => 'boolean',
        'whatsapp_verified' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bloodRequests(): HasMany
    {
        return $this->hasMany(BloodRequestResponse::class);
    }

    public function isEligible(): bool
    {
        return $this->eligibility_status === 'eligible' && $this->account_status === 'verified';
    }

    public function canDonate(): bool
    {
        if (!$this->isEligible()) {
            return false;
        }

        if ($this->last_donation_date) {
            return $this->last_donation_date->diffInDays(now()) >= 56;
        }

        return true;
    }

    public function getAgeAttribute(): int
    {
        return $this->date_of_birth->diffInYears(now());
    }
}
