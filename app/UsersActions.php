<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersActions extends Model
{
    protected $fillable = [
        'func',
        'sec_id',
        'setor_id',
        'action'
    ];
    protected $table = 'users_actions';
}
