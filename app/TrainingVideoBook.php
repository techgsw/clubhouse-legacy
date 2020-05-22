<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingVideoBook extends Model
{
    protected $table = 'training_video_book';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
