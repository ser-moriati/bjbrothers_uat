<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $fillable = [
        'project_name',
        'project_owner',
        'project_address',
        'project_detail',
        'ref_category_id',
        'project_image',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'projects';
}
