<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SafetyCategory extends Model
{
    //
    protected $fillable = [
        'safety_category_name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'safety_categorys';
}
