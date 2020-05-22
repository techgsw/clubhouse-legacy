<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingVideoChapter extends Model
{
    protected $table = 'training_video_chapter';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function trainingVideos()
    {
        return $this->belongsToMany(TrainingVideo::class);
    }

    public function trainingVideoBook()
    {
        return $this->belongsTo(TrainingVideoBook::class);
    }
}
