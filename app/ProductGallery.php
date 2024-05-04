<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model
{
    //
    protected $fillable = [
        'image_name',
        'ref_product_id',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'product_gallerys';
}
