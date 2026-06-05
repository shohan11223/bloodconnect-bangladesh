<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('donor_id')->unique(); // Auto-generated ID
            $table->enum('blood_group', ['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-']);
            $table->decimal('hemoglobin_level', 5, 2)->nullable(); // g/dL
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('profile_photo')->nullable();
            
            // Permanent Address
            $table->string('permanent_division');
            $table->string('permanent_district');
            $table->string('permanent_upazila')->nullable();
            $table->string('permanent_union')->nullable();
            $table->string('permanent_ward')->nullable();
            $table->text('permanent_address');
            
            // Present Address
            $table->string('present_division');
            $table->string('present_district');
            $table->string('present_upazila')->nullable();
            $table->string('present_union')->nullable();
            $table->string('present_ward')->nullable();
            $table->text('present_address');
            
            // Contact Information
            $table->string('mobile_number');
            $table->string('emergency_mobile_number');
            $table->string('whatsapp_number')->nullable();
            $table->string('gmail_address');
            
            // Status Information
            $table->enum('account_status', ['pending', 'verified', 'suspended'])->default('pending');
            $table->boolean('email_verified')->default(false);
            $table->boolean('whatsapp_verified')->default(false);
            $table->timestamp('last_donation_date')->nullable();
            $table->integer('donation_count')->default(0);
            $table->enum('eligibility_status', ['eligible', 'ineligible', 'pending_review'])->default('pending_review');
            $table->text('ineligibility_reason')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('blood_group');
            $table->index('account_status');
            $table->index('eligibility_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donors');
    }
};