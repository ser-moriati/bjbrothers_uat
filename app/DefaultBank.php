<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefaultBank extends Model
{
    //
    protected $fillable = [
        'bank_name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'default_bank';
}
