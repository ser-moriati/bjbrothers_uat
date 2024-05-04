<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'product_code',
        'product_name',
        'product_price',
        'product_version',
        'ref_category_id',
        'ref_sub_category_id',
        'ref_brand_id',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'products';

    public function product_codes()
    {
        return $this->hasMany('App\ProductCode', 'ref_product_id', 'id');
    }
}
