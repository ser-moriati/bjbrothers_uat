<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = [
        'category_name',
        'category_image',
        'category_detail',
        'banner_image'
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'categorys';

    public function sub_category()
    {
        return $this->hasMany('App\SubCategory', 'ref_category_id', 'id');
    }
}
