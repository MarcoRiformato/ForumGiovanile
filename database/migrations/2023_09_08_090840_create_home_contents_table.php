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
        Schema::create('homepages', function (Blueprint $table) {
            $table->id();
            $table->text('main_title')->nullable();
            $table->text('sub_title')->nullable();
            $table->text('about_us')->nullable();
            $table->text('latest_news_title')->nullable();
            $table->text('latest_news_desc')->nullable();
            $table->text('our_vision_title')->nullable();
            $table->text('our_vision_desc')->nullable();
            $table->text('team_title')->nullable();
            $table->text('team_desc')->nullable();
            $table->string('team_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_contents');
    }
};
