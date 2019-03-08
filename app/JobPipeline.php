<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class JobPipeline extends Model
{
    protected $table = 'job_pipeline';
    protected $guarded = [
        'open'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'edited_at'
    ];
}
