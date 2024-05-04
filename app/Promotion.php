<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    //
    protected $fillable = [
        'title',
        'detail',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'promotions';
}
