<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    //
    protected $fillable = [
        'shipping_name',
        'shipping_detail',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'shipping_method';
}
