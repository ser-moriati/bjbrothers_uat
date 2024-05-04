<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutService extends Model
{
    //
    protected $fillable = [
        'about_service_year',
        'about_service_detail',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'about_service';
}
