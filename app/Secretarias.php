<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Secretarias extends Model
{
    protected $fillable = [
        'name',
        'email'
    ];
    protected $table = 'secretarias';

    public function employees(){
        return $this->hasMany(User::class, 'sec_id');
    }
}
