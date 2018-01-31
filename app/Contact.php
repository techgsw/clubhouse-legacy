<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact';
    protected $guarded = [];
    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getName()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getTitle()
    {
        if (!is_null($this->title) || !is_null($this->organization)) {
            return ($this->title ?: 'Works') . ($this->organization ? ' at ' . $this->organization : '');
        }
        return null;
    }

    public function getNoteCount()
    {
        // TODO
    }
}
