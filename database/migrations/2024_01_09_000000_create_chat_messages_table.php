<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('live_chat_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sender_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->string('sender_type'); // 'user', 'agent', 'system'
            $table->string('sender_name')->nullable();
            $table->text('message');
            $table->json('attachments')->nullable();
            
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            
            $table->timestamps();
            
            $table->index('live_chat_id');
            $table->index('sender_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};