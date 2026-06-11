<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_contents', function (Blueprint $table) {
            $table->id();

            $table->string('hero_title')->nullable(); // optional override for the styled hero headline

            $table->string('equip_title')->nullable();
            $table->text('equip_sub')->nullable();

            $table->string('cat_eyebrow')->nullable();
            $table->string('cat_title')->nullable();
            $table->text('cat_sub')->nullable();

            $table->string('services_title')->nullable();
            $table->text('services_sub')->nullable();

            $table->string('projects_eyebrow')->nullable();
            $table->string('projects_title')->nullable();
            $table->text('projects_sub')->nullable();

            $table->string('ongoing_eyebrow')->nullable();
            $table->string('ongoing_title')->nullable();
            $table->text('ongoing_sub')->nullable();

            $table->string('cta_eyebrow')->nullable();
            $table->string('cta_title')->nullable();
            $table->text('cta_text')->nullable();

            $table->string('faq_eyebrow')->nullable();
            $table->string('faq_title')->nullable();
            $table->text('faq_sub')->nullable();

            $table->string('testi_eyebrow')->nullable();
            $table->string('testi_title')->nullable();
            $table->text('testi_text')->nullable();

            $table->string('blog_eyebrow')->nullable();
            $table->string('blog_title')->nullable();
            $table->text('blog_sub')->nullable();

            $table->timestamps();
        });

        // Seed the single row with the current on-page text so the admin sees it pre-filled.
        DB::table('home_contents')->insert([
            'id' => 1,
            'equip_title' => 'Equipment Showcase',
            'equip_sub' => "Our clients' feedback speaks volumes about our commitment and quality.",
            'cat_eyebrow' => 'Category',
            'cat_title' => 'Equipment Categories',
            'cat_sub' => 'Browse our extensive collection of construction equipment',
            'services_title' => 'Trusted Construction Services for Every Client',
            'services_sub' => "Delivering reliable, innovative, and high-quality construction solutions tailored to every client's needs. Committed to excellence with services designed to build trust and lasting value.",
            'projects_eyebrow' => 'Our Project',
            'projects_title' => 'Showcasing Our Work',
            'projects_sub' => "Our clients' feedback speaks volumes about our commitment and quality.",
            'ongoing_eyebrow' => 'Our Ongoing Project',
            'ongoing_title' => 'Work in Action',
            'ongoing_sub' => 'Delivering quality through every step of the process.',
            'cta_eyebrow' => 'Contact Us Anytime',
            'cta_title' => "Have a Project in Mind? Let's Talk.",
            'cta_text' => 'Bandan Bhagwati is a sacred expression of devotion and cultural unity. It represents the deep bond between faith, tradition, and community, bringing people together in reverence and shared belief.',
            'faq_eyebrow' => "FAQ's",
            'faq_title' => 'frequently asked questions',
            'faq_sub' => 'Delivering quality through every step of the process.',
            'testi_eyebrow' => 'Testimonials',
            'testi_title' => 'What our clients say',
            'testi_text' => 'Our clients trust us to deliver quality construction on time. Here is what they have to say about working with Bandan Bhagwati Nirman Sewa.',
            'blog_eyebrow' => 'Our Blog',
            'blog_title' => 'Insights & Updates',
            'blog_sub' => 'Explore expert insights, industry updates, and project stories from our team.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('home_contents');
    }
};
