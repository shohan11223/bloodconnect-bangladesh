<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('receiver_token')->unique(); // For temporary authentication
            
            // Patient Information
            $table->string('patient_name');
            $table->enum('blood_group', ['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-']);
            $table->decimal('hemoglobin', 5, 2)->nullable();
            $table->integer('quantity_needed'); // Units
            $table->string('hospital_name');
            $table->string('room_number');
            $table->string('blood_donation_location');
            
            // Location Information
            $table->string('division');
            $table->string('district');
            $table->string('upazila')->nullable();
            $table->string('emergency_contact_number');
            
            // Request Information
            $table->dateTime('required_date_time');
            $table->enum('status', ['active', 'fulfilled', 'cancelled', 'expired'])->default('active');
            $table->text('special_notes')->nullable();
            
            // Timestamps
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('fulfilled_at')->nullable();
            $table->softDeletes();
            
            $table->index('receiver_token');
            $table->index('blood_group');
            $table->index('status');
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receivers');
    }
};