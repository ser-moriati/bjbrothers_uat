<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Geographies extends Model
{
    //
    protected $fillable = [
        
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'geographies';
}
