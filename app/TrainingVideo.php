<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingVideo extends Model
{
    protected $table = 'training_video';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function trainingVideoChapters()
    {
        return $this->belongsToMany(TrainingVideoChapter::class);
    }

}
