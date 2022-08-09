<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobTagWhiteList extends Model
{
    protected $table = 'job_tag_white_list';
    protected $fillable = [
        'tag_name'
    ];
    public $timestamps = false;
}
