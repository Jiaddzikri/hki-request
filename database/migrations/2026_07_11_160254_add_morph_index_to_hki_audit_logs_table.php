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
        // Because model_type is a TEXT column, MySQL requires a prefix length for indexing.
        \Illuminate\Support\Facades\DB::statement('CREATE INDEX hki_audit_logs_model_type_model_id_index ON hki_audit_logs (model_type(191), model_id)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hki_audit_logs', function (Blueprint $table) {
            $table->dropIndex('hki_audit_logs_model_type_model_id_index');
        });
    }
};
