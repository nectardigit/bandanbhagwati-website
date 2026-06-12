<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_contents', function (Blueprint $table) {
            $table->string('service_page_title')->nullable();
            $table->text('service_page_desc')->nullable();
            $table->string('equipment_page_title')->nullable();
            $table->text('equipment_page_desc')->nullable();
            $table->string('project_page_title')->nullable();
            $table->text('project_page_desc')->nullable();
            $table->string('team_page_title')->nullable();
            $table->text('team_page_desc')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('home_contents', function (Blueprint $table) {
            $table->dropColumn([
                'service_page_title', 'service_page_desc',
                'equipment_page_title', 'equipment_page_desc',
                'project_page_title', 'project_page_desc',
                'team_page_title', 'team_page_desc',
            ]);
        });
    }
};
