<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    protected $table = 'mentor';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'mentor_tag');
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
                $q->orWhere('mentor.description', 'like', "%{$term}%");
            });
        }

        // Match tags
        $tag = $request->tag;
        if (!empty($tag)) {
            $query->whereHas('tags', function ($query) use ($tag) {
                $query->where('tag.name', $tag);
            });
        }

        return $query;
    }
}
