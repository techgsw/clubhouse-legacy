<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class MentorSocialMediaLink extends Model
{
    public $timestamps = false;

    protected $table = 'mentor_social_media_link';
    protected $guarded = [];

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }

}
