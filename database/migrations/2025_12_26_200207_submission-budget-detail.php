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
        Schema::create('ltr_submission_budget_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('ltr_submissions')->cascadeOnDelete();

            $table->string('item_description');

            // Kuantitas
            $table->integer('volume');
            $table->string('unit');

            // Harga
            $table->decimal('unit_cost', 15, 2);
            $table->decimal('total_cost', 15, 2);
            $table->string('category');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ltr_submission_budget_details');
    }
};
