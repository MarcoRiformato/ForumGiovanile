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
    Schema::create('campaigns', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description')->nullable();
        $table->boolean('testingCampaign')->nullable();
        $table->boolean('status')->nullable();
        $table->date('startingDate')->nullable();
        $table->date('endDate')->nullable();
        $table->softDeletes();
        $table->timestamps();
    });
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::dropIfExists('campaigns');
}
};
