<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->string('price')->nullable()->after('description');   // e.g. "Rs. 15,000 / day"
            $table->json('specs')->nullable()->after('price');            // [{label, value}]
            $table->json('gallery')->nullable()->after('specs');          // [path, path, ...]
        });
    }

    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn(['price', 'specs', 'gallery']);
        });
    }
};
