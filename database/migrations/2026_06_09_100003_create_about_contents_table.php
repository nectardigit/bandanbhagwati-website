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
            $table->string('banner_title')->default('About Us');
            $table->string('eyebrow')->default('About');
            $table->string('heading')->nullable();
            $table->json('features')->nullable();       // [{title, text}]
            $table->string('card_one')->nullable();
            $table->string('card_two')->nullable();
            $table->string('years_label')->default('10+ years');
            $table->string('years_sub')->default('of experience');
            $table->string('explore_url')->default('/service');

            // Contact CTA block
            $table->string('cta_eyebrow')->nullable();
            $table->string('cta_heading')->nullable();
            $table->text('cta_text')->nullable();

            // Images (file manager picks)
            $table->string('photo1')->nullable();
            $table->string('photo2')->nullable();
            $table->string('badge_image')->nullable();
            $table->string('cone_image')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_contents');
    }
};
