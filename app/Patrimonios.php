<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patrimonios extends Model
{
    protected $fillable = [
        'sec_id',
        'nome',
        'codigo',
        'numero',
        'dtaquisicao',
        'estado',
        'situacao',
        'localizacao',
        'observacao'
    ];
    protected $table = 'patrimonios';

}
