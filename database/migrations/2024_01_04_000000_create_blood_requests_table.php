<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receiver_id')->constrained('receivers')->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->enum('blood_group', ['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-']);
            $table->integer('quantity_needed'); // Units
            $table->text('description');
            
            $table->enum('status', ['pending', 'accepted', 'fulfilled', 'cancelled', 'expired'])->default('pending');
            $table->integer('accepted_count')->default(0);
            $table->integer('fulfilled_count')->default(0);
            
            $table->dateTime('required_date_time');
            $table->dateTime('expires_at')->nullable();
            $table->timestamp('fulfilled_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            
            $table->text('cancellation_reason')->nullable();
            $table->boolean('is_emergency')->default(true);
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('blood_group');
            $table->index('status');
            $table->index('is_emergency');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_requests');
    }
};