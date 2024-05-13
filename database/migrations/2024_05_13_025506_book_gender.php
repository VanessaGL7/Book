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
        Schema::create('book_gender', function (Blueprint $table) {
            $table->unsignedBigInteger('id_book')->nullable();
            $table->unsignedBigInteger('id_gender')->nullable();

            $table->foreign('id_book')->references('id_book')->on('book');
            $table->foreign('id_gender')->references('id_gender')->on('gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_gender');
    }
};
