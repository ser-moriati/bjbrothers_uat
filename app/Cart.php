<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $fillable = [
        'ref_product_id',
        'ref_color_id',
        'ref_size_id',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'carts';
}
