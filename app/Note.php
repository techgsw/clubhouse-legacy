<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Note extends Model
{
    protected $table = 'note';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notable()
    {
        return $this->morphTo();
    }

    public static function contact($contact_id, array $options = null)
    {
        $notes = array();

        $contact_notes = Note::where('notable_type', 'App\\Contact')
            ->join('user', 'user.id', '=', 'note.user_id')
            ->where('notable_id', $contact_id)
            ->select('user.id as create_user_id', DB::raw('CONCAT(user.first_name, " ", user.last_name) as create_user_name'), 'note.*')
            ->get();
        foreach ($contact_notes as $note) {
            $notes[$note->created_at->getTimestamp()] = $note;
        }
        $contact = Contact::find($contact_id);

        $contact_jobs = DB::table('contact_job')
            ->where('contact_job.contact_id', $contact->id)
            ->select('contact_job.id')
            ->get();

        if ($contact_jobs) {
            $contact_job_ids = array();
            foreach ($contact_jobs as $contact_job) {
                $contact_job_ids[] = $contact_job->id;
            }
            $contact_job_notes = Note::where('notable_type', 'App\\ContactJob')
                ->join('contact_job', 'note.notable_id', '=', 'contact_job.id')
                ->join('job', 'contact_job.job_id', '=', 'job.id')
                ->join('user', 'user.id', '=', 'note.user_id')
                ->whereIn('notable_id', $contact_job_ids)
                ->select('user.id as create_user_id', DB::raw('CONCAT(user.first_name, " ", user.last_name) as create_user_name'), 'job.id as job_id', 'job.title as job_title', 'job.organization_name as job_organization', 'note.*')
                ->get();
            foreach ($contact_job_notes as $note) {
                $notes[$note->created_at->getTimestamp()] = $note;
            }
        }

        if (!is_null($contact->user_id)) {
            $user_id = $contact->user_id;
            $inquiries = DB::table('inquiry')
                ->where('inquiry.user_id', $user_id)
                ->select('inquiry.id')
                ->get();

            if ($inquiries) {
                $inquiry_ids = array();
                foreach ($inquiries as $inquiry) {
                    $inquiry_ids[] = $inquiry->id;
                }
                $inquiry_notes = Note::where('notable_type', 'App\\Inquiry')
                    ->join('inquiry', 'note.notable_id', '=', 'inquiry.id')
                    ->join('job', 'inquiry.job_id', '=', 'job.id')
                    ->join('user', 'user.id', '=', 'note.user_id')
                    ->whereIn('notable_id', $inquiry_ids)
                    ->select('user.id as create_user_id', DB::raw('CONCAT(user.first_name, " ", user.last_name) as create_user_name'), 'job.id as job_id', 'job.title as job_title', 'job.organization_name as job_organization', 'note.*')
                    ->get();
                foreach ($inquiry_notes as $note) {
                    $notes[$note->created_at->getTimestamp()] = $note;
                }
            }
        }

        krsort($notes);

        return $notes;
    }

    public static function contactJob($contact_job_id, array $options = null)
    {
        return Note::where('notable_type', 'App\ContactJob')
            ->where('notable_id', $contact_job_id);
    }

    public static function inquiry($inquiry_id, array $options = null)
    {
        return Note::where('notable_type', 'App\Inquiry')
            ->where('notable_id', $inquiry_id);
    }
}
