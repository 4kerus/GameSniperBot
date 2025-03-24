<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaceitNick extends Model
{
    protected $fillable = ['nick'];

    public function chatFaceitNicks()
    {
        return $this->hasMany(ChatFaceitNick::class);
    }

    public function trackings()
    {
        return $this->hasMany(FaceitTracking::class);
    }
}
