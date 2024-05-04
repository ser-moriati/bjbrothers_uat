<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaintenanceCategory extends Model
{
    //
    protected $fillable = [
        'maintenance_category_name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'maintenance_categorys';
}
