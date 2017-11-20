<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Job extends Model
{
    protected $table = 'job';
    protected $guarded = [
        'open'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'edited_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function isNew()
    {
        $new = (new \DateTime('NOW'))->sub(new \DateInterval('P14D'));
        return $this->created_at > $new;
    }

    public function getURL()
    {
        return "/job/" . $this->id . "-" . preg_replace('/\s/', '-', preg_replace('/[^\w\s]/', '', ucwords($this->title))) . "-" . preg_replace('/\s/', '-', preg_replace('/[^\w\s]/', '', ucwords($this->organization)));
    }

    public static function open()
    {
        return Job::where('open', true)->orderBy('created_at', 'desc');
    }

    public static function filter(Request $request)
    {
        if (Auth::user() && Auth::user()->can('create-job')) {
            // Admins can filter by status
            $status = request('status');
            switch ($status) {
                case 'open':
                    $jobs = Job::where('open', true);
                    break;
                case 'closed':
                    $jobs = Job::where('open', false);
                    break;
                case 'all':
                default:
                    $jobs = Job::where('id', '>', 0);
                    break;
            }
        } else {
            // Users can only see open jobs
            $jobs = Job::where('open', true);
        }

        $type = request('job_type');
        if ($type && $type != 'all') {
            $jobs->where('job_type', $type);
        }

        $league = request('league');
        if ($league && $league != 'all') {
            $jobs->where('league', $league);
        }

        if ($org = request('organization')) {
            $jobs->where('organization', 'like', "%{$org}%");
        }

        if ($loc = request('state')) {
            $jobs->where('state', $loc);
        }

        return $jobs;
    }
}
