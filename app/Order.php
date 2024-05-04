<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'order_name',
        'order_detail',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'orders';

    public function order_products()
    {
        return $this->hasMany('App\OrderHasProduct', 'ref_order_id', 'id');
    }
}
