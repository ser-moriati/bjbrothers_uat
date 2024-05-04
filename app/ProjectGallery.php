<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectGallery extends Model
{
    //
    protected $fillable = [
        'image_name',
        'ref_project_id',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'project_gallerys';
}
