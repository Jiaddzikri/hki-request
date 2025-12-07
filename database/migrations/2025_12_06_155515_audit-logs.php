<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
        $table->id();
        $table->string('model_type');
        $table->unsignedBigInteger('model_id');
        $table->unsignedBigInteger('user_id');
        $table->string('action');
    
        $table->text('payload');
        $table->char('previous_hash', 64)->default('0');
        $table->char('current_hash', 64);
        $table->text('digital_signature')->nullable();
        $table->timestamps();
        
        $table->index(['previous_hash', 'current_hash']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('audit_logs');
    }
};
