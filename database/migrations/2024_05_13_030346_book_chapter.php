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
        Schema::create('book_chapter', function (Blueprint $table) {
            $table->unsignedBigInteger('id_book')->nullable();
            $table->unsignedBigInteger('id_chapter')->nullable();
            $table->timestamps();

            $table->foreign('id_book')->references('id_book')->on('book');
            $table->foreign('id_chapter')->references('id_chapter')->on('chapter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_chapter');
    }
};
