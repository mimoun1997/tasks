<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    //
    protected $guarded = [];

    public function map()
    {
        return [
            'id' => $this->id,
            'url' => $this->url
        ];
    }

    public function user()
    {
//        return $this->hasOne(User::class);    -> Camp users.photo_id -> No és el que volem, no embrutar taula principal
        return $this->belongsTo(User::class);
    }

    public function setUser(User $user)
    {
        $this->user_id = $user->id;
        $this->save();
        return $this;
    }
}
