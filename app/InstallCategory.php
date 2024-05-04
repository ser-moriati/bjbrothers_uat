<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstallCategory extends Model
{
    //
    protected $fillable = [
        'install_category_name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'install_categorys';
}
