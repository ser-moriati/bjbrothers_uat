<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    //
    protected $fillable = [
        
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'roles';
}
