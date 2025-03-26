<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\TelegramUser;
use App\Models\UserChat;

class TelegramService
{

    public function setChatMembers(Chat $chat, array $members)
    {
        foreach ($members as $member) {
            UserChat::updateOrCreate(
                ['telegram_user_id' => $member->id, 'chat_id' => $chat->id]
            );
        }
    }

    public function getUserChats(TelegramUser $user)
    {
        return $user->chats;
    }
}
