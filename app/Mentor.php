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
        'updated_at',
        'activated_at'
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

    /**
     * This is a hack to determinie if a mentor's Calend.ly link is valid.
     *
     * Since we let mentors set up their own accounts and send us the link, we cannot use the API
     * to determine calendar availability. These CURL calls emulate the browser loading an
     * embedded Calend.ly instance to see if an error message shows up.
     *
     * The first CURL call should return "This link is not valid" if the URL was written incorrectly.
     *
     * In some instances, the calendar will be marked as unavailable because of various account
     * issues. When this happens, the initial pageload works but subsequent calls made by the embed
     * js will reveal an error. The second CURL call emulates the browser request that determines
     * this using the user's "UUID" (not a real uuid by the way). This request will return "calendar
     * is currently unavailable" if there are account issues.
     **/
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
            if (strpos($data, 'is not valid') !== false) {
                Log::error('Mentor calendly link is not valid: '.$this->calendly_link);
            } else {
                preg_match('/"uuid":"([^"]+)"/', $data, $calendly_uuid_match_array);
                if (isset($calendly_uuid_match_array[1])) {
                    // Extract the user's UUID from json in the initial pageload
                    $calendly_uuid = $calendly_uuid_match_array[1];

                    // A timezone, start date and end date is required. It's unclear how this date range is used
                    // but I'm mimicking what the embed code does.
                    $date_range_call_params = array(
                        'timezone' => "America/Phoenix",
                        'range_start' => (new \DateTime('now'))->format('Y-m-d'),
                        'range_end' => (new \DateTime('last day of this month'))->format('Y-m-d')
                    );

                    $date_range_call_url = "https://calendly.com/api/booking/event_types/".$calendly_uuid."/calendar/range"
                                    .'?'.http_build_query($date_range_call_params);
                    $ch2 = curl_init($date_range_call_url);
                    $headers = [
                        "Cache-Control: no-cache"
                    ];
                    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch2, CURLOPT_FRESH_CONNECT, 1);
                    curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);
                    try {
                        $date_range_call_data = curl_exec($ch2);
                    } catch (\Exception $e) {
                        Log::error('Error running curl for mentor calendly date range call: '.$date_range_call_url);
                        Log::error($e);
                        curl_close($ch2);
                        return false;
                    }
                    curl_close($ch2);

                    if (!$date_range_call_data) {
                        Log::error('No data when running curl for mentor calendly date range call: '.$date_range_call_url);
                    } else {
                        return strpos($date_range_call_data, 'calendar is currently unavailable') === false;
                    }
                }
            }
        } else {
            Log::error('No data when running curl for mentor calendly link: '.$this->calendly_link);
        }
        return false;
    }

    /**
     * Block users from creating a request for a mentor if the mentor already has had a request in the past week
     */
    public function isMentorBlockedFromRequests()
    {
        Log::info($this->mentorRequests()->toSql());
        return $this->mentorRequests()->where('created_at', '>', (new \DateTime())->sub(new \DateInterval('P7D')))
                                      ->count() > 0;
    }
}
