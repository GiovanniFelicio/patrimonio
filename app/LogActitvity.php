<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class LogActitvity extends Model
{
    protected $fillable = [
        'subject',
        'url',
        'method',
        'ip',
        'agent',
        'user_id'
    ];
    protected $table = 'log_activities';
}
