<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    //
    protected $fillable = [
        'series_name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'series';
    
    public function products()
    {
        return $this->hasMany('App\Product', 'ref_series_id', 'id');
    }
}
