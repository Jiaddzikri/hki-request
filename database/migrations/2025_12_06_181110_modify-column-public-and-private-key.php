<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('public_key');
            $table->dropColumn('private_key_encrypted');
            $table->addColumn('text', 'public_key')->nullable();
            $table->addColumn('text', 'private_key_encrypted')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('public_key');
            $table->dropColumn('private_key_encrypted');
            $table->string('public_key')->nullable();
            $table->string('private_key_encrypted')->nullable();
        });

    }
};
