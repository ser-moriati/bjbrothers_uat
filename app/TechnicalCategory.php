<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechnicalCategory extends Model
{
    //
    protected $fillable = [
        'technical_category_name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'technical_categorys';
}
