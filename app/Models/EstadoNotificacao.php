<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoNotificacao extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    
    protected $table = "estado_notificacoes";
}
