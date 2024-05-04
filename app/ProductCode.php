<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCode extends Model
{
    //
    protected $fillable = [
        'product_code',
        'ref_product_id',
        'ref_color_id',
        'ref_size_id',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'product_codes';
}
