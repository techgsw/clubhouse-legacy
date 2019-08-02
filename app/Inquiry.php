<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Inquiry extends Model
{
    protected $table = 'inquiry';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
    public function pipeline()
    {
        return $this->belongsTo(Pipeline::class);
    }

    public function job_pipeline()
    {
        return $this->hasOne(JobPipeline::class, 'pipeline_id', 'pipeline_id');
    }

    public function notes()
    {
        return $this->morphMany('App\Note', 'notable');
    }

    public static function filter($job_id, Request $request)
    {
        $inquiries = Inquiry::selectRaw('inquiry.*')->join('user as u','user_id', 'u.id')->where('job_id', $job_id);

        $pipeline_id = request('step');
        
        if ($pipeline_id != 'all' && !is_null($pipeline_id)) {
            $inquiries->where('pipeline_id', '=', $pipeline_id);
        }

        $sort = request('sort');
        switch ($sort) {
            case "alpha":
                $inquiries->orderBy('u.last_name', 'asc');
                break;
            case "alpha-reverse":
                $inquiries->orderBy('u.last_name', 'desc');
                break;
            default:
                $inquiries->orderBy('inquiry.created_at', 'desc');
                break;
        }

        return $inquiries;
    }

    public function generateJobInterestToken()
    {
        $this->job_interest_token = hash('sha256', "$this->id $this->user_id $this->job_id ".rand(0,100)*rand(0,100));
    }
}
