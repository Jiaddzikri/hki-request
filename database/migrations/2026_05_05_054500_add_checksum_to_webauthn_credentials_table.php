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
        // Table name used by laragear/webauthn
        if (Schema::hasTable('webauthn_credentials')) {
            Schema::table('webauthn_credentials', function (Blueprint $table) {
                $table->string('public_key_checksum')->nullable()->after('public_key')
                    ->comment('HMAC-SHA256 of user_id + public_key to detect admin tampering');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('webauthn_credentials')) {
            Schema::table('webauthn_credentials', function (Blueprint $table) {
                $table->dropColumn('public_key_checksum');
            });
        }
    }
};
