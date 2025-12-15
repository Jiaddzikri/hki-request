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
    Schema::create('hki_types', function (Blueprint $table) {
        $table->id();
        
        $table->foreignId('parent_id')
              ->nullable()
              ->constrained('hki_types')
              ->nullOnDelete(); 

        $table->string('name'); 
        $table->boolean('requires_claims')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('hki_types');
    }
};
