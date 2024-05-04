<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberCategory extends Model
{
    //
    protected $fillable = [
        'category_name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'member_categorys';
}
