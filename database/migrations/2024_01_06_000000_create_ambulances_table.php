<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ambulances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            $table->string('ambulance_id')->unique();
            $table->string('ambulance_name');
            $table->string('vehicle_number')->unique();
            $table->string('owner_name');
            $table->string('driver_name');
            $table->string('driver_mobile');
            $table->string('driver_license')->nullable();
            
            // Location
            $table->string('division');
            $table->string('district');
            $table->string('upazila');
            $table->text('address');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            // Pricing
            $table->decimal('per_kilometer_fare', 8, 2);
            $table->decimal('base_fare', 8, 2)->default(0);
            
            // Status
            $table->enum('availability_status', ['available', 'occupied', 'maintenance', 'inactive'])->default('available');
            $table->enum('approval_status', ['pending', 'moderator_approved', 'admin_approved', 'rejected'])->default('pending');
            
            // Media
            $table->string('ambulance_photo')->nullable();
            $table->json('additional_photos')->nullable();
            
            // Verification
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->text('rejection_reason')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('approval_status');
            $table->index('availability_status');
            $table->index('district');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ambulances');
    }
};