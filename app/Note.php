<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class Note extends Authenticatable
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

    public static function profile($user_id, array $options = null)
    {
        return Note::where('notable_type', 'App\Profile')
         ->where('notable_id', $user_id);
    }
}
