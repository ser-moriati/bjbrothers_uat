<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    //
    protected $fillable = [
        
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'districts';
}
