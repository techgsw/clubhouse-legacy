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

    public function notes()
    {
        return $this->morphMany('App\Note', 'notable');
    }

    public static function filter($job_id, Request $request)
    {
        $inquiries = Inquiry::where('job_id', $job_id);

        $rating = request('rating');
        switch ($rating) {
            case "up":
                $inquiries->where('rating', '>', '0');
                break;
            case "maybe":
                $inquiries->where('rating', '0');
                break;
            case "down":
                $inquiries->where('rating', '<', '0');
                break;
            case "none":
                $inquiries->whereNull('rating');
                break;
            default:
                break;
        }

        $sort = request('sort');
        switch ($sort) {
            case "alpha":
                $inquiries->orderBy('name', 'asc');
                break;
            case "alpha-reverse":
                $inquiries->orderBy('name', 'desc');
                break;
            case "rating":
                $inquiries->orderBy('rating', 'desc');
                break;
            case "recent":
            default:
                $inquiries->orderBy('created_at', 'desc');
                break;
        }

        return $inquiries;
    }
}
