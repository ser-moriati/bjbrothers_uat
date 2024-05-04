<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Technical extends Model
{
    //
    protected $fillable = [
        'technical_name',
        'technical_owner',
        'technical_address',
        'technical_detail',
        'ref_category_id',
        'technical_image',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'technicals';
}
