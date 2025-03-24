<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class TelegramUser extends Model
    {
        protected $table = 'telegram_users';

        protected $fillable = ['telegram_id', 'username', 'first_name', 'last_name', 'faceit_nick', 'phone_number', 'language_code', 'is_premium'];


        public function userChats()
        {
            return $this->hasMany(UserChat::class);
        }

        public function chats()
        {
            return $this->belongsToMany(Chat::class, 'user_chats');
        }

        public function faceitTrackings()
        {
            return $this->hasMany(FaceitTracking::class);
        }

    }
