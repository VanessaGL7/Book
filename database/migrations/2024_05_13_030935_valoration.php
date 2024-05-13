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
        Schema::create('valoration', function (Blueprint $table) {
            $table->id('id_valoration');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->unsignedBigInteger('id_book')->nullable();
            $table->integer('valoration');
            $table->text('commentary');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('user');
            $table->foreign('id_book')->references('id_book')->on('book');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valoration');
    }
};
