<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingCost extends Model
{
    //
    protected $fillable = [
        'shipping_cost_name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'shipping_costs';
}
