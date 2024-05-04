<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    //
    protected $fillable = [
        'portfolio_name',
        'portfolio_owner',
        'portfolio_address',
        'portfolio_detail',
        'ref_category_id',
        'portfolio_image',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'portfolios';
}
