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
    Schema::create('ltr_submissions', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')->constrained('users');
        $table->foreignId('academic_period_id')->constrained('ltr_academic_periods');
        $table->foreignId('grant_scheme_id')->constrained('ltr_grant_schemes');
        
        $table->string('title');
        $table->text('abstract')->nullable();
        $table->string('keywords')->nullable();
        
        $table->string('status')->default('DRAFT')->index();
        
        $table->decimal('total_budget_proposed', 15, 2)->default(0);
        $table->decimal('total_budget_approved', 15, 2)->nullable(); // Diisi setelah revisi
        
        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ltr_submissions');
    }
};
