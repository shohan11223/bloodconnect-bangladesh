<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            
            $table->string('hospital_id')->unique();
            $table->string('hospital_name');
            $table->string('license_number')->unique();
            $table->enum('hospital_type', ['government', 'private', 'ngo', 'military']);
            
            // Location
            $table->string('division');
            $table->string('district');
            $table->string('upazila');
            $table->text('address');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            // Contact
            $table->string('emergency_contact');
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->text('website')->nullable();
            
            // Facilities
            $table->boolean('has_ambulance_support')->default(false);
            $table->boolean('has_icu')->default(false);
            $table->integer('icu_beds')->default(0);
            $table->boolean('has_blood_bank')->default(false);
            $table->text('blood_bank_details')->nullable();
            
            // Media & Documentation
            $table->string('hospital_photo')->nullable();
            $table->json('photo_gallery')->nullable();
            $table->string('license_document')->nullable();
            
            // Approval Status
            $table->enum('approval_status', ['pending', 'moderator_approved', 'admin_approved', 'rejected'])->default('pending');
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->text('rejection_reason')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('approval_status');
            $table->index('hospital_type');
            $table->index('district');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospitals');
    }
};