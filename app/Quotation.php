<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    //
    protected $fillable = [
        'ref_product_id',
        'ref_color_id',
        'ref_size_id',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'quotations';
    public function quotation_details()
    {
        return $this->hasMany('App\QuotationDetail', 'ref_quotation_id', 'id');
    }
}
