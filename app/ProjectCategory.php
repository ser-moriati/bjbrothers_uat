<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    //
    protected $fillable = [
        'project_category_name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'project_categorys';
}
