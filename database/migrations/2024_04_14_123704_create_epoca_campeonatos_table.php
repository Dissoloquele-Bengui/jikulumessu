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
        Schema::create('epoca_campeonatos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_campeonato');
            $table->unsignedBigInteger('id_epoca');
            $table->foreign('id_campeonato')
                ->references('id')
                ->on('campeonatos')
                ->onDelete('cascade');
            $table->foreign('id_epoca')
                ->references('id')
                ->on('epocas')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epoca_campeonatos');
    }
};
