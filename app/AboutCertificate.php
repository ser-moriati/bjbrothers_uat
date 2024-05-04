<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutCertificate extends Model
{
    //
    protected $fillable = [
        'about_certificate_name',
        'about_certificate_image',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'about_certificates';
}
