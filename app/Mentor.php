<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    protected $table = 'mentor';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function socialMediaLinks()
    {
        return $this->hasMany(MentorSocialMediaLink::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'mentor_tag');
    }

    public function mentorRequests()
    {
        return $this->hasMany(MentorRequest::class);
    }

    // Scopes
    public function scopeSearch($query, $request)
    {
        $query->join('contact', 'mentor.contact_id', '=', 'contact.id');

        // Match term on name and description
        $term = $request->term;
        if (!empty($term)) {
            $query->where(function ($q) use ($term) {
                $q->where(DB::raw('CONCAT(contact.first_name, " ", contact.last_name)'), 'like', "%{$term}%");
            });
        }

        // Match tags
        $tag = $request->tag;
        if (!empty($tag)) {
            $query->whereHas('tags', function ($query) use ($tag) {
                $query->where('tag.name', $tag);
            });
        }

        $league_abbreviation = $request->league;
        if (!empty($league_abbreviation)) {
            $query->where(function($league_query) use ($league_abbreviation) {
                $league_query->whereHas('contact.organizations.leagues', function($organization_with_league_query) use ($league_abbreviation) {
                    $organization_with_league_query->where('league.abbreviation', $league_abbreviation);
                })->orWhereHas('contact.organizations.league', function($league_organization_query) use ($league_abbreviation) {
                    $league_organization_query->where('abbreviation', $league_abbreviation);
                });
            });
        }

        return $query;
    }

    public function getURL($absolute = false)
    {
        $url = "/mentor/" . $this->id . "-" . preg_replace('/\s/', '-', preg_replace('/[^\w\s]/', '', ucwords($this->contact->getName())));
        if ($absolute) {
            $url = url($url);
        }
        return $url;
    }

    public function getLinkedInLink()
    {
        foreach ($this->socialMediaLinks as $link) {
            if ($link->social_media_type == 'linkedin') {
                return $link->link;
            }
        }
        return null;
    }

    public function isCalendlyLinkValid()
    {
        $ch = curl_init($this->calendly_link);
        $headers = [
            "Cache-Control: no-cache"
        ];
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        try {
            $data = curl_exec($ch);
        } catch (\Exception $e) {
            Log::error('Error running curl for mentor calendly link: '.$this->calendly_link);
            Log::error($e);
            curl_close($ch);
            return false;
        }
        curl_close($ch);

        if ($data) {
            return strpos($data, 'is not valid') === false;
        } else {
            Log::error('No data when running curl for mentor calendly link: '.$this->calendly_link);
            return false;
        }
    }
}
