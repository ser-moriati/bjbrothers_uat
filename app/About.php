<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    //
    protected $fillable = [
        'business',
        'chart',
        'factory'
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'about';
}
