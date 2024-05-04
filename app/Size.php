<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    //
    protected $fillable = [
        'size_name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'sizes';
}
