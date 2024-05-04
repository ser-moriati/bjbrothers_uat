<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutCustomer extends Model
{
    //
    protected $fillable = [
        'about_customer_name',
        'about_customer_image',
        'ref_category_id',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'about_customers';
}
