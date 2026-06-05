<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blood_request_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blood_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('donor_id')->constrained()->cascadeOnDelete();
            
            $table->enum('status', ['accepted', 'cancelled', 'fulfilled'])->default('accepted');
            $table->integer('units_provided')->default(1);
            $table->text('notes')->nullable();
            
            $table->timestamp('responded_at')->useCurrent();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('fulfilled_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['blood_request_id', 'donor_id']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_request_responses');
    }
};