<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderHasProduct extends Model
{
    //
    protected $fillable = [
        'ref_order_id',
        'ref_product_id',
        'ref_color_id',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'order_has_product';

    public function product()
    {
        return $this->hasOne('App\Product', 'id', 'ref_product_id');
    }
    public function color()
    {
        return $this->hasOne('App\Color', 'id', 'ref_color_id');
    }
    public function size()
    {
        return $this->hasOne('App\Size', 'id', 'ref_size_id');
    }
}
