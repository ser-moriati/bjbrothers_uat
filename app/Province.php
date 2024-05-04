<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    //
    protected $fillable = [
        
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'provinces';
}
