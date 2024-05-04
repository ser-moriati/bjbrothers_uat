<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberAddress extends Model
{
    //
    protected $fillable = [
        'ref_member_id',
        'address_type',
        'addr',
        'ref_geographie_id',
        'ref_province_id',
        'ref_amphures_id',
        'ref_district_id',
        'zipcode'
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'member_address';
    
    public function province()
    {
        return $this->hasOne('App\Province', 'id', 'ref_province_id');
    }

    public function amphures()
    {
        return $this->hasOne('App\Amphures', 'id', 'ref_amphures_id');
    }

    public function district()
    {
        return $this->hasOne('App\District', 'id', 'ref_district_id');
    }
}
