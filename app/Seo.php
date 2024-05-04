<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    //
    protected $fillable = [
        'module',
        'meta_title',
        'meta_keywords',
        'meta_description'
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'seo';
}
