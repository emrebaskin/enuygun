<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ToDo
 * @package App\Models
 */
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
