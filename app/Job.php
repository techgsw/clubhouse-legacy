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

    public function assignments()
    {
        return $this->hasMany(ContactJob::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function isNew()
    {
        $new = (new \DateTime('NOW'))->sub(new \DateInterval('P14D'));
        return $this->created_at > $new;
    }

    public function inquiryTotals()
    {
        $totals = array();

        foreach ($this->inquiries as $inquiry) {
            if (array_key_exists($inquiry->job_pipeline->name, $totals)) {

                $totals[$inquiry->job_pipeline->name] += 1;
            } else {
                $totals[$inquiry->job_pipeline->name] = 1;
            }    
        }

        return $totals;
    }

    public function contactAssignmentTotals()
    {
        $totals = array();
        
        foreach ($this->assignments as $contact_job) {   
            if (array_key_exists($contact_job->job_pipeline->name, $totals)) {

                $totals[$contact_job->job_pipeline->name] += 1;
            } else {
                $totals[$contact_job->job_pipeline->name] = 1;
            }            
        }
        
        return $totals;
    }

    public function getURL($absolute = false)
    {
        $url = "/job/" . $this->id . "-" . preg_replace('/\s/', '-', preg_replace('/[^\w\s]/', '', ucwords($this->title))) . "-" . preg_replace('/\s/', '-', preg_replace('/[^\w\s]/', '', ucwords($this->organization_name)));
        if ($absolute) {
            $url = url($url);
        }
        return $url;
    }

    public function getTimeRemainingString()
    {
        $create_date = clone($this->created_at);

        if ($this->job_type_id == 1) {
            return 'Does not expire'; 
        } else if ($this->job_type_id == 2) {
            $end_time = $create_date->add(new \DateInterval('P30D'));
        } else if ($this->job_type_id == 3) {
            $end_time = $create_date->add(new \DateInterval('P45D'));
        } else if ($this->job_type_id == 4) {
            $end_time = $create_date->add(new \DateInterval('P60D'));
        } 

        $end_time = $end_time->format('Y-m-d H:i:s');
        // calculation of extendedtimediff by auction extended_end_time
        $seconds_left = (strtotime($end_time) - microtime(true));

        $days=(int)($seconds_left/86400);
        if ($days != 0 )
        {
            $day_string = "{$days}d ";
        }

        $hours = (int)(($seconds_left-($days*86400))/3600);
        if ($days != 0 or $hours != 0) {
            $hour_string = "{$hours}h ";
        }

        $minutes = (int)(($seconds_left-$days*86400-$hours*3600)/60);
        if ($days != 0 or $hours != 0 or $minutes != 0) {
            $minutes_string = "{$minutes}m ";
        }

        $seconds = (int)(($seconds_left-$days*86400-$hours*3600-$minutes*60));
        if ($days != 0 or $hours != 0 or $minutes != 0 or $seconds != 0) {
            $seconds_string = "{$seconds}s";
        }

        $countdown_string = "$day_string$hour_string";

        $is_over =  ($seconds_left <= 0);

        if ($is_over)
        {
            return 'Expired on '.$end_time;
        }
        else
        {
            return 'Posting expires in '.$countdown_string;
        }
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
            $jobs->where('organization_name', 'like', "%{$org}%");
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
