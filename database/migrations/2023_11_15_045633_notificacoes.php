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
        
        Schema::dropIfExists('notificacoes');
        Schema::create('notificacoes', function (Blueprint $table) {
            $table->id();
            $table->string('assunto');
            $table->longText('descricao');
            $table->date('data');
            $table->time('hora');
            $table->unsignedBigInteger("id_categoria");
            $table->foreign('id_categoria')->references('id')->on('categoria_notificacoes')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificacoes');
    }
};
