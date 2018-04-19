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

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class);
    }

    public function isNew()
    {
        $new = (new \DateTime('NOW'))->sub(new \DateInterval('P14D'));
        return $this->created_at > $new;
    }

    public function inquiryTotals()
    {
        $totals = [
            'none' => 0,
            'up' => 0,
            'maybe' => 0,
            'down' => 0
        ];
        foreach ($this->inquiries as $i) {
            if ($i->rating === 1) {
                $totals['up']++;
            } else if ($i->rating === 0) {
                $totals['maybe']++;
            } else if ($i->rating === -1) {
                $totals['down']++;
            } else {
                $totals['none']++;
            }
        }
        return $totals;
    }

    public function getURL($absolute = false)
    {
        $url = "/job/" . $this->id . "-" . preg_replace('/\s/', '-', preg_replace('/[^\w\s]/', '', ucwords($this->title))) . "-" . preg_replace('/\s/', '-', preg_replace('/[^\w\s]/', '', ucwords($this->organization)));
        if ($absolute) {
            $url = url($url);
        }
        return $url;
    }

    public static function open()
    {
        return Job::where('open', true)->orderBy('created_at', 'desc');
    }

    public static function unfeature($id)
    {
        $job = Job::find($id);
        if (!$job) {
            return false;
        }

        $rank = $job->rank;

        $job->featured = false;
        $job->rank = 0;
        $job->edited_at = new \DateTime('NOW');
        $job->save();

        // Shift neighbors with lower rank up one
        $neighbors = Job::where('featured', 1)->orderBy('rank', 'ASC')->get();
        if (!$neighbors) {
            return $job;
        }
        foreach ($neighbors as $i => $neighbor) {
            $neighbor->rank = $i+1;
            $neighbor->edited_at = new \DateTime('NOW');
            $neighbor->save();
        }

        return $job;
    }

    public static function filter(Request $request)
    {
        $jobs = Job::where('job.id', '>', 0);

        // Admin-only
        if (Auth::user() && Auth::user()->can('create-job')) {
            // Admins can filter by new inquiries
            $new_inquiries = request('new-inquiries') && request('new-inquiries') == '1';
            if ($new_inquiries) {
                $jobs = $jobs->join('inquiry', 'job.id', '=', 'inquiry.job_id');
                $jobs->whereHas('inquiries', function ($query) {
                    $query->whereNull('rating');
                });
                $jobs = $jobs->select(\DB::raw('job.*, COUNT(inquiry.id)'));
                $jobs->orderBy(\DB::raw('MAX(inquiry.created_at)'), 'desc');
                $jobs->groupBy('job.id');
            }
            // Admins can filter by status
            $status = request('status');
            switch ($status) {
                case 'open':
                    $jobs = $jobs->where('open', true);
                    break;
                case 'closed':
                    $jobs = $jobs->where('open', false);
                    break;
                case 'all':
                default:
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

        if ($state = request('state')) {
            $jobs->where('state', $state);
        }

        if ($country = request('country')) {
            $jobs->where('country', $country);
        }

        return $jobs;
    }
}
