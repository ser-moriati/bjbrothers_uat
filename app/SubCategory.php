<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    //
    protected $fillable = [
        'sub_category_code',
        'sub_category_name',
        'ref_category_id',
        'sub_category_image',
        'old_sort',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'sub_categorys';
    public function series()
    {
        return $this->hasMany('App\Series', 'ref_sub_category_id', 'id');
    }
}
