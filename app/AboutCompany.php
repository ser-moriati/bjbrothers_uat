<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutCompany extends Model
{
    //
    protected $fillable = [
        'about_company_year',
        'about_company_detail',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'about_companys';
}
