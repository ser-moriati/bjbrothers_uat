<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //
    protected $fillable = [
        'brand_name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'brands';
}
