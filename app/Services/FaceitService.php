<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\FaceitMatch;
use App\Models\FaceitNick;
use App\Models\NotifiedMatchFaceit;
use App\Models\TelegramUser;

class FaceitService
{
    public function getEloByNick($nick)
    {
        return FaceitNick::where('nick', $nick)->first();
    }

    public function getChatEloList(Chat $chat)
    {
        return $chat->chatFaceitNicks()->with('faceitNick')->get()->pluck('faceitNick.nick');
    }

    public function getNickByUserInChat(TelegramUser $user, Chat $chat)
    {
        return $chat->chatFaceitNicks()->whereHas('faceitNick.trackings', function ($query) use ($user) {
            $query->where('telegram_user_id', $user->id);
        })->with('faceitNick')->first();
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
        if (!$this->isMatchNotifiedInChat($match, $chat)) {
            return $this->setMatchNotifiedInChat($match, $chat);
        }
    }

    public function setUserNick(TelegramUser $user, $nick)
    {
        return FaceitNick::firstOrCreate(['nick' => $nick])->trackings()->updateOrCreate([
            'telegram_user_id' => $user->id
        ]);
    }

    public function setUserNickInChat(TelegramUser $user, Chat $chat, $nick)
    {
        $faceitNick = FaceitNick::firstOrCreate(['nick' => $nick]);
        return $chat->chatFaceitNicks()->updateOrCreate([
            'faceit_nick_id' => $faceitNick->id
        ]);
    }
}
