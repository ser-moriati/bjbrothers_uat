<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ecatalogue extends Model
{
    //
    protected $fillable = [
        'ecatalogue_pdf_name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'ecatalogues';
}
