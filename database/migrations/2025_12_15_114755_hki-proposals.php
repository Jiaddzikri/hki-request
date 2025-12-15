<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('hki_proposals', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignId('user_id')->constrained('users');
        $table->foreignId('hki_type_id')->constrained('hki_types');
        $table->string('title',255)->nullable();
        $table->timestamp('publication_date')->nullable();
        $table->string('publication_city', 100)->nullable();
        $table->text('description')->nullable();
        $table->string('status', 20)->default('DRAFT')->comment('DRAFT, SUBMITTED, REVISION, APPROVED, REJECTED'); 
        $table->timestamps();
        $table->softDeletes();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('hki_proposals');
    }
};
