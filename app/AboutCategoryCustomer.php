<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutCategoryCustomer extends Model
{
    //
    protected $fillable = [
        'about_category_customer_name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'about_category_customers';
}
