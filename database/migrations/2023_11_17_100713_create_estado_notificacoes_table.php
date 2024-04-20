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
        Schema::dropIfExists('estado_notificacaos');
        Schema::create('estado_notificacoes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_destinatario');
            $table->unsignedBigInteger('id_notificacao')->nullable();
            $table->Integer('estado');
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_destinatario')->references('id')->on('destinatarios')->onDelete('cascade');
            $table->foreign('id_notificacao')->references('id')->on('notificacoes')->onDelete('cascade');


            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estado_notificacoes');
    }
};
