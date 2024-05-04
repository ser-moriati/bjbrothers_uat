<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    protected $fillable = [
        'iframe',
        'address',
        'business_hours',
        'phone',
        'mobile_phone',
        'fax',
        'email',
        'line_id',
        'line_qr',
        'map_image',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'contact';
}
