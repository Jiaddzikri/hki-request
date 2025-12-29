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
    Schema::create('ltr_generated_letters', function (Blueprint $table) {
        $table->id();
        $table->string('model_type');
        $table->unsignedBigInteger('model_id');
        
        $table->string('letter_number')->unique();
        $table->string('file_path');
        $table->string('qr_token');
        
        $table->foreignId('signer_id')->constrained('users');
        $table->timestamp('signed_at');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ltr_generated_letters');
    }
};
