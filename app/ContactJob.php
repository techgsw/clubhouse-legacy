<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ContactJob extends Model
{
    protected $table = 'contact_job';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    // Same on inquiries
    public function pipeline()
    {
        return $this->belongsTo(Pipeline::class);
    }
    public function job_pipeline()
    {
        return $this->hasOne(JobPipeline::class, 'pipeline_id', 'pipeline_id');
    }
    public function admin_user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function notes()
    {
        return $this->morphMany('App\Note', 'notable');
    }

    public static function filter($job_id, Request $request)
    {
        $contact_applications = ContactJob::selectRaw('contact_job.*')->join('contact as c','contact_id', 'c.id')->where('job_id', $job_id);

        $filter = request('filter');
        $pipeline_id = request('step');
        $request_data = $request->all();

        if ($pipeline_id != 'all' && !$filter && !is_null($pipeline_id)) {
            $contact_applications->where('pipeline_id', '=', $pipeline_id);
            $request_data['filter'] = '';
        } else {
            if ($filter == 'positive') {
                $contact_applications->where('pipeline_id', '>=', 2)->whereNull('status');
                $request_data['step'] = 'none';
            } elseif ($filter == 'negative') {
                $contact_applications->where('pipeline_id', '>=', 2)->where('status', '=', 'halted');
                $request_data['step'] = 'none';
            }
        }
        $request->merge($request_data);

        $sort = request('sort');
        switch ($sort) {
            case "alpha":
                $contact_applications->orderBy('c.last_name', 'asc');
                break;
            case "alpha-reverse":
                $contact_applications->orderBy('c.last_name', 'desc');
                break;
            case "recent":
            default:
                $contact_applications->orderBy('contact_job.created_at', 'desc');
                break;
        }

        return $contact_applications;
    }
}
