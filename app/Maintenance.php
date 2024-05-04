<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    //
    protected $fillable = [
        'maintenance_name',
        'maintenance_owner',
        'maintenance_address',
        'maintenance_detail',
        'ref_category_id',
        'maintenance_image',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'maintenances';
}
