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
        Schema::create('epapers', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // e.g. "প্রথম পাতা", "শেষ পাতা"
            $table->date('publish_date');
            $table->unsignedInteger('page_number');
            $table->string('image'); // path to newspaper page image
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epapers');
    }
};
