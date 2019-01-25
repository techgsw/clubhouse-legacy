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

    public function user()
    {
        return $this->belongsTo(User::class);
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
        $contact_applications = ContactJob::where('job_id', $job_id);

        $rating = request('rating');
        switch ($rating) {
            case "up":
                $contact_applications->where('rating', '>', '0');
                break;
            case "maybe":
                $contact_applications->where('rating', '0');
                break;
            case "down":
                $contact_applications->where('rating', '<', '0');
                break;
            case "none":
                $contact_applications->whereNull('rating');
                break;
            default:
                break;
        }

        $sort = request('sort');
        switch ($sort) {
            case "alpha":
                $contact_applications->orderBy('name', 'asc');
                break;
            case "alpha-reverse":
                $contact_applications->orderBy('name', 'desc');
                break;
            case "rating":
                $contact_applications->orderBy('rating', 'desc');
                break;
            case "recent":
            default:
                $contact_applications->orderBy('created_at', 'desc');
                break;
        }

        return $contact_applications;
    }
}
