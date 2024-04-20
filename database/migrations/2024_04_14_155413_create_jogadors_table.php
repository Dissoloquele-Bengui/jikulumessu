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
        Schema::create('jogadores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('posicao');
            $table->date('data_nascimento');
            $table->integer('numero');
            $table->unsignedBigInteger('id_equipa');
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
        Schema::dropIfExists('jogadors');
    }
};
