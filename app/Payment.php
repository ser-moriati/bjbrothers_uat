<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = [
        'payment_name',
        'payment_detail',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'payment_method';
}
