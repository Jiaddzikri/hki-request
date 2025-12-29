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
        Schema::create('ltr_submission_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('ltr_submissions')->cascadeOnDelete();

            $table->foreignId('user_id')->nullable()->constrained('users');

            $table->string('name');
            $table->string('email')->nullable();
            $table->string('identifier_number')->nullable();

            $table->string('role');
            $table->string('faculty_dept')->nullable();

            $table->boolean('is_confirmed')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ltr_submission_members');
    }
};
