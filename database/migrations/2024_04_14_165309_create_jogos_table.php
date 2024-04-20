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
        Schema::create('jogos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_campeonato_equipa_1');
            $table->unsignedBigInteger('id_campeonato_equipa_2');
            $table->unsignedBigInteger('id_epoca');
            $table->foreign('id_campeonato_equipa_1')
                ->references('id')
                ->on('campeonato_equipas')
                ->onDelete('cascade');
            $table->foreign('id_campeonato_equipa_2')
                ->references('id')
                ->on('campeonato_equipas')
                ->onDelete('cascade');
            
            $table->foreign('id_epoca')
                ->references('id')
                ->on('epocas')
                ->onDelete('cascade');
            $table->time('hora_inicio');
            $table->time('hora_termino');
            $table->date('dia');
            $table->integer('gols_1')->default(0);
            $table->integer('gols_2')->default(0);
            $table->integer('estado')->default(0);
            $table->softdeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jogos');
    }
};
