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
        Schema::create('campeonato_equipas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_campeonato');
            $table->unsignedBigInteger('id_equipa');
            $table->integer('vitorias')->default(0);
            $table->integer('empates')->default(0);
            $table->integer('derrotas')->default(0);
            
            $table->foreign('id_campeonato')
                ->references('id')
                ->on('campeonatos')
                ->onDelete('cascade');
                
            $table->foreign('id_equipa')
                ->references('id')
                ->on('equipas')
                ->onDelete('cascade');
            $table->softdeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campeonato_equipas');
    }
};
