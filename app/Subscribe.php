<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    //
    protected $fillable = [
        'subscribe_email',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'subscribes';

}
