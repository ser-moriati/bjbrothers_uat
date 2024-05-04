<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    //
    protected $fillable = [
        'position',
        'workplace',
        'description',
        'detail',
        'banner',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'careers';
}
