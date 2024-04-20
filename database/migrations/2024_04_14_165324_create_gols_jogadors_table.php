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
        Schema::create('gols_jogadors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jogador');
            $table->unsignedBigInteger('id_jogo');
            $table->integer('numero')->default(0);
            $table->string('minutos')->default(0);            
            $table->foreign('id_jogador')
                ->references('id')
                ->on('jogadores')
                ->onDelete('cascade');
                
            $table->foreign('id_jogo')
                ->references('id')
                ->on('jogos')
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
        Schema::dropIfExists('gols_jogadors');
    }
};
