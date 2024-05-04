<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    //
    protected $fillable = [
        
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'product_prices';
}
