<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Job extends Model
{
    protected $table = 'job';
    protected $guarded = [
        'job_status_id'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'edited_at',
        'upgraded_at',
        'extended_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobCreateUser()
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

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'job_tag');
    }

    public function isNew()
    {
        $new = (new \DateTime('NOW'))->sub(new \DateInterval('P14D'));
        return $this->created_at > $new;
    }

    public function inquiryTotals()
    {
        $totals = array('none' => 0, 'up' => 0, 'maybe' => 0, 'down' => 0);

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
        $totals = array('none' => 0, 'up' => 0, 'maybe' => 0, 'down' => 0);
        
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
        if (!is_null($this->upgraded_at)) {
            $start_date = clone($this->upgraded_at);
        } else {
            $start_date = clone($this->created_at);
        }

        if (!is_null($this->extended_at) && strtotime($this->extended_at) > strtotime($this->upgraded_at)) {
            // extensions are only for 30 days regardless of job type
            $end_time = clone($this->extended_at)->add(new \DateInterval('P30D'));
        } else if ($this->job_type_id == JOB_TYPE_ID['sbs_default']) {
            return 'Does not expire'; 
        } else if ($this->job_type_id == JOB_TYPE_ID['user_free']) {
            $end_time = $start_date->add(new \DateInterval('P30D'));
        } else if ($this->job_type_id == JOB_TYPE_ID['user_premium']) {
            $end_time = $start_date->add(new \DateInterval('P45D'));
        } else if ($this->job_type_id == JOB_TYPE_ID['user_platinum']) {
            $end_time = $start_date->add(new \DateInterval('P60D'));
        }

        //TODO: move the rest of this to a helper class
        $end_time = $end_time->format('Y-m-d H:i:s');

        if ($this->job_status_id == JOB_STATUS_ID['expired']) {
            return 'Expired on '.$end_time;
        }

        // calculation of extendedtimediff by auction extended_end_time
        $seconds_left = (strtotime($end_time) - microtime(true));

        $countdown_string='';

        $days=(int)($seconds_left/86400);
        if ($days != 0 ) {
            $countdown_string .= "{$days}d ";
        }

        $hours = (int)(($seconds_left-($days*86400))/3600);
        if ($days != 0 or $hours != 0) {
            $countdown_string .= "{$hours}h ";
        }

        $minutes = (int)(($seconds_left-$days*86400-$hours*3600)/60);
        if ($days == 0 and ($hours != 0 or $minutes != 0)) {
            $countdown_string .= "{$minutes}m ";
        }

        $seconds = (int)(($seconds_left-$days*86400-$hours*3600-$minutes*60));
        if ($days == 0 and $hours == 0 and ($minutes != 0 or $seconds != 0)) {
            $countdown_string .= "{$seconds}s";
        }

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

    public static function unfeature($id)
    {
        $job = Job::find($id);
        if (!$job) {
            return false;
        }

        $rank = $job->rank;

        $job->featured = false;
        $rank = 1;
        $last_job = Job::whereNotNull('rank')
            ->where('job_status_id', $job->job_status_id)
            ->where('featured',0)
            ->orderBy('rank', 'desc')
            ->first();
        if ($last_job) {
            $rank = $last_job->rank+1;
        }
        $job->rank = $rank;
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
            if (array_key_exists($status, JOB_STATUS_ID)) {
                $jobs = $jobs->where('job_status_id', JOB_STATUS_ID[$status]);
            }
        } else {
            // Users can only see open jobs
            $jobs = Job::where('job_status_id', JOB_STATUS_ID['open']);
        }

        $type = request('job_discipline');
        if ($type && $type != 'all') {
            $jobs->whereHas('tags', function($query) use ($type) {
                $query->where('slug', $type);
            });
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

    /**
     * Extract jobs that should be marked as expired.
     *
     * Admin jobs and jobs marked as expired are not included.
     * Free jobs expire 30 days from their created or upgraded date
     * Premium jobs expire 45 days from their created or upgraded date
     * Platinum jobs expire 60 days from their created or upgraded date
     * Jobs that have been extended and not later upgraded expire 30 days from their extension date
     *
     * @param int $in_number_of_days include jobs that will expire after a certain number of days
     * @param bool $include_jobs_after include jobs that should have expired after the number of days
     * @return mixed
     */
    public static function findExpiredJobs($in_number_of_days = 0, $include_jobs_after = true)
    {
        $days_operator = $include_jobs_after ? '>=' : '=';

        return Job::where('job_status_id', '!=', JOB_STATUS_ID['expired'])
            ->where(function($expire_time_wheres) use ($in_number_of_days, $days_operator) {
                $expire_time_wheres->where(function($extended_at_where) use ($in_number_of_days, $days_operator) {
                    // regardless of job type, if extended_at is the latest time, check if it's been 30 days
                    $extended_at_where->where('job_type_id', '!=', JOB_TYPE_ID['sbs_default'])
                        ->where(\DB::raw('COALESCE(extended_at,0)'), '>', \DB::raw('COALESCE(upgraded_at,0)'))
                        ->where(\DB::raw('TIMESTAMPDIFF(DAY, extended_at, NOW())'), $days_operator, 30 - $in_number_of_days);
                })->orWhere(function ($no_extension_where) use ($in_number_of_days, $days_operator) {
                    // else if exteded_at is not the latest time
                    $no_extension_where->where(\DB::raw('COALESCE(extended_at,0)'), '<=', \DB::raw('COALESCE(upgraded_at,0)'))
                        ->where(function($job_type_where) use ($in_number_of_days, $days_operator) {
                            $job_type_where->Where(function ($user_free_where) use ($in_number_of_days, $days_operator) {
                                $user_free_where->where('job_type_id', JOB_TYPE_ID['user_free'])
                                    ->where(\DB::raw('TIMESTAMPDIFF(DAY,'
                                        . 'COALESCE(upgraded_at,created_at),'
                                        . 'NOW())'
                                    ), $days_operator, 30 - $in_number_of_days);
                            })->orWhere(function ($user_premium_where) use ($in_number_of_days, $days_operator) {
                                $user_premium_where->where('job_type_id', JOB_TYPE_ID['user_premium'])
                                    ->where(\DB::raw('TIMESTAMPDIFF(DAY,'
                                        . 'COALESCE(upgraded_at,created_at),'
                                        . 'NOW())'
                                    ), $days_operator, 45 - $in_number_of_days);
                            })->orWhere(function ($user_platinum_where) use ($in_number_of_days, $days_operator) {
                                $user_platinum_where->where('job_type_id', JOB_TYPE_ID['user_platinum'])
                                    ->where(\DB::raw('TIMESTAMPDIFF(DAY,'
                                        . 'COALESCE(upgraded_at,created_at),'
                                        . 'NOW())'
                                    ), $days_operator, 60 - $in_number_of_days);
                            });
                        });
                });
            })->get();
    }
}
