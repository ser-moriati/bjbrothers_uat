<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    //
    protected $fillable = [
        'banner_name',
        'video',
        'product_recommended',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'home';
}
