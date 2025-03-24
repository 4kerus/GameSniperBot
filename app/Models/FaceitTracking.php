<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaceitTracking extends Model
{
    protected $fillable = ['telegram_user_id', 'faceit_nick_id'];

    public function telegramUser()
    {
        return $this->belongsTo(TelegramUser::class);
    }

    public function faceitNick()
    {
        return $this->belongsTo(FaceitNick::class);
    }
}
