<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blockchain_records', function (Blueprint $table) {
            $table->id();
            $table->string('record_type'); // 'room', 'user', 'housekeeping_task'
            $table->unsignedBigInteger('record_id');
            $table->string('action'); // 'create', 'update', 'delete'
            $table->json('data_before')->nullable();
            $table->json('data_after');
            $table->string('hash');
            $table->string('previous_hash')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('timestamp');
            $table->timestamps();
            
            $table->index(['record_type', 'record_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blockchain_records');
    }
};
