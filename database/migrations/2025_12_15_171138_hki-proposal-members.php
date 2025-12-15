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
        Schema::create('hki_proposal_members', function (Blueprint $table) {
        $table->id();
        $table->foreignUuid('hki_proposal_id')->constrained('hki_proposals')->cascadeOnDelete();
        $table->foreignId('user_id')->nullable()->constrained('users'); 
        $table->string('name'); 
        $table->string('identifier');
        $table->string('role');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hki_proposal_members');
    }
};
