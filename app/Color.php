<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    //
    protected $fillable = [
        'color_code',
        'color_name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'colors';
}
