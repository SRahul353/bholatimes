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
        Schema::table('epapers', function (Blueprint $table) {
            $table->longText('pages_data')->nullable()->after('layout_data');
            $table->integer('total_pages')->default(4)->after('pages_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('epapers', function (Blueprint $table) {
            $table->dropColumn('pages_data');
            $table->dropColumn('total_pages');
        });
    }
};
