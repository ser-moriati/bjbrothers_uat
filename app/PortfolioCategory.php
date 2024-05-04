<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PortfolioCategory extends Model
{
    //
    protected $fillable = [
        'portfolio_category_name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'portfolio_categorys';
}
