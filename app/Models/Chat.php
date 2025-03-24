<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['tg_chat_id'];

    public function chatFaceitNicks()
    {
        return $this->hasMany(ChatFaceitNick::class);
    }


    public function users()
    {
        return $this->belongsToMany(TelegramUser::class, 'user_chats');
    }

    public function notifiedMatches()
    {
        return $this->hasMany(NotifiedMatchFaceit::class);
    }

}
