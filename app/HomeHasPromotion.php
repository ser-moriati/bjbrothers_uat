<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeHasPromotion extends Model
{
    //
    protected $fillable = [
        'module',
        'ref_module_id'
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'home_has_promotion';
}
