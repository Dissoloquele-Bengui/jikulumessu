<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;
    protected $fillable = [
        'it_id_user',
        'vc_descricao',
        'vc_endereco',
        'vc_dispositivo',
    ];
}
