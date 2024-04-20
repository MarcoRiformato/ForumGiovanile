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
            $table->string('lavoro');
            $table->string('imageUrl');
            $table->string('azienda');
            $table->string('luogo');
            $table->string('stipendio');
            $table->timestamp('data_pubblicazione')->nullable();
            $table->text('descrizione')->nullable(); // Assuming you might want to store job descriptions
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
