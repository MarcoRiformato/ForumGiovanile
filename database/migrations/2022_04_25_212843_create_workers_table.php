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
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('contract_type')->nullable();
            $table->string('job_titles')->nullable();
            $table->text('description')->nullable();
            $table->string('residence')->nullable();
            $table->date('availability')->nullable();
            $table->boolean('has_car')->nullable();
            $table->text('work_experience')->nullable();
            $table->string('languages')->nullable();
            $table->boolean('has_hccp_certificate')->nullable();
            $table->string('education')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers');
    }
};
