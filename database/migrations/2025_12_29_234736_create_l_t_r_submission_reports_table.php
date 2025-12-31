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
        Schema::create('ltr_submission_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('ltr_submissions')->cascadeOnDelete();

            $table->string('phase');
            $table->text('notes')->nullable();

            $table->string('file_path');
            $table->string('original_name');
            $table->string('file_hash');

            $table->enum('status', ['PENDING', 'ACCEPTED', 'REJECTED'])->default('PENDING');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ltr_submission_reports');
    }
};
