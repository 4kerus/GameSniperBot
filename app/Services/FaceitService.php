<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\ChatFaceitNick;
use App\Models\FaceitMatch;
use App\Models\FaceitNick;
use App\Models\NotifiedMatchFaceit;
use App\Models\TelegramUser;

class FaceitService
{
    public function getEloByNick($nick)
    {
        return FaceitNick::where('nick', $nick)->value('elo');
    }


    public function getChatNicksArray(){

    }

    public function getChatEloList(Chat $chat)
    {
//        return ChatFaceitNick::where('chat_id', $chat->id)->pluck('faceit_nick');
    }


    public function getNickByUserInChat(TelegramUser $user, Chat $chat)
    {
        return ChatFaceitNick::where('chat_id', $chat->id)
            ->where('telegram_user_id', $user->id)
            ->value('faceit_nick') ?: null;
    }

    public function isMatchNotifiedInChat(FaceitMatch $match, Chat $chat): bool
    {
        return NotifiedMatchFaceit::where('faceit_match_id', $match->id)->where('chat_id', $chat->id)->exists();
    }

    public function setMatchNotifiedInChat(FaceitMatch $match, Chat $chat)
    {
        return NotifiedMatchFaceit::create([
            'faceit_match_id' => $match->id,
            'chat_id' => $chat->id,
        ]);
    }

    public function notifyMatchInChat(FaceitMatch $match, Chat $chat)
    {
        return NotifiedMatchFaceit::firstOrCreate([
            'faceit_match_id' => $match->id,
            'chat_id' => $chat->id,
        ]);
    }


    public function setUserNick(TelegramUser $user, $nick)
    {
        return ChatFaceitNick::updateOrCreate(
            ['chat_id' => $user->telegram_id, 'telegram_user_id' => $user->id],
            ['faceit_nick' => $nick]
        );

    }

    public function setUserNickInChat(TelegramUser $user, Chat $chat, $nick)
    {
        return ChatFaceitNick::updateOrCreate(
            ['chat_id' => $chat->id, 'telegram_user_id' => $user->id],
            ['faceit_nick' => $nick]
        );
    }




}
