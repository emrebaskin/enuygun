<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    protected $table = 'todos';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'level',
        'time'
    ];
    public $incrementing = false;
}
