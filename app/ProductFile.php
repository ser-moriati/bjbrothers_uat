<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductFile extends Model
{
    //
    protected $fillable = [
        'file_name',
        'ref_product_id',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'product_files';
}
