<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChat extends Model
{
    protected $fillable = ['telegram_user_id', 'chat_id'];

    public function telegramUser()
    {
        return $this->belongsTo(TelegramUser::class);
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
