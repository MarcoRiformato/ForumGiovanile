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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('lavoro')->nullable();
            $table->string('imageUrl')->nullable();
            $table->string('azienda')->nullable();
            $table->string('luogo')->nullable();
            $table->string('stipendio')->nullable();
            $table->timestamp('data_pubblicazione')->nullable();
            $table->text('descrizione')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
