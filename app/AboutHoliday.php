<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutHoliday extends Model
{
    //
    protected $fillable = [
        'about_holiday_name',
        'about_holiday_date',
        'about_holiday_image',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'about_holidays';
}
