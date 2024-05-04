<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Install extends Model
{
    //
    protected $fillable = [
        'install_name',
        'install_owner',
        'install_address',
        'install_detail',
        'ref_category_id',
        'install_image',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'installs';
}
