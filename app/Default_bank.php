<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class default_bank extends Model
{
    protected $fillable = [
        'bank_name',
        'bank_number',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'default_bank';
}
