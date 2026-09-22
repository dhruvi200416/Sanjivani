<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_contents', function (Blueprint $table) {
            $table->id();
            $table->string('banner_text')->nullable();
            $table->string('story_heading')->nullable();
            $table->string('story_lead')->nullable();
            $table->text('story_para1')->nullable();
            $table->text('story_para2')->nullable();
            $table->string('main_image')->nullable();
            $table->string('sub_image')->nullable();
            $table->string('founder_name')->nullable();
            $table->string('founder_designation')->nullable();
            $table->text('mission_text')->nullable();
            $table->text('vision_text')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_contents');
    }
};