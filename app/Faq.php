<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    //
    protected $fillable = [
        'faq_question',
        'faq_answer',
        'sort',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'faqs';
}
