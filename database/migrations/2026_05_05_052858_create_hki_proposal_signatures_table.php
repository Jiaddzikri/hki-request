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
        Schema::create('hki_proposal_signatures', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('hki_proposal_id')->constrained('hki_proposals')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('credential_id'); // The ID of the passkey used
            $table->text('signature'); // The raw signature blob
            $table->text('authenticator_data'); // Device metadata
            $table->text('client_data_json'); // The signed data (contains challenge/nonce)
            $table->timestamp('signed_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hki_proposal_signatures');
    }
};
