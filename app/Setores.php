<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setores extends Model
{
    protected $fillable = [
        'sec_id',
        'setor_id',
        'name',
        'status'
    ];
    protected $table = 'setores';

}
