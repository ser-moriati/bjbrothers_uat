<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    //
    protected $fillable = [
        'status_name',
        'color_code',
        'color_background'
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'order_status';
}
