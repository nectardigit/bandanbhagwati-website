<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_contents', function (Blueprint $table) {
            $table->string('clients_eyebrow')->nullable()->after('hero_title');
            $table->string('clients_title')->nullable()->after('clients_eyebrow');
            $table->text('clients_sub')->nullable()->after('clients_title');
        });
    }

    public function down(): void
    {
        Schema::table('home_contents', function (Blueprint $table) {
            $table->dropColumn(['clients_eyebrow', 'clients_title', 'clients_sub']);
        });
    }
};
