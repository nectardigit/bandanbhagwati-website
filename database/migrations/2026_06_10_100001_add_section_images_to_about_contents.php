<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_contents', function (Blueprint $table) {
            $table->string('banner_image')->nullable()->after('cone_image');
            $table->string('service_image')->nullable()->after('banner_image');
            $table->string('faq_image')->nullable()->after('service_image');
        });
    }

    public function down(): void
    {
        Schema::table('about_contents', function (Blueprint $table) {
            $table->dropColumn(['banner_image', 'service_image', 'faq_image']);
        });
    }
};
