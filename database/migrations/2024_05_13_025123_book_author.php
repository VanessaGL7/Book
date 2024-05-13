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
        Schema::create('book_author', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_book')->nullable();
            $table->unsignedBigInteger('id_author')->nullable();
            $table->timestamps();

            $table->foreign('id_book')->references('id_book')->on('book');
            $table->foreign('id_author')->references('id_author')->on('author');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_author');
    }
};
