<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Safety extends Model
{
    //
    protected $fillable = [
        'safety_name',
        'safety_owner',
        'safety_address',
        'safety_detail',
        'ref_category_id',
        'safety_image',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'safetys';
}
