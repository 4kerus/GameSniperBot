<?php

namespace App\Telegram\Commands;

use App\Models\Chat;
use App\Models\TelegramUser;
use App\Services\FaceitService;
use Telegram\Bot\Commands\Command;

class TrackerCommand extends Command
{
    protected string $name = 'track';
    protected string $description = 'Track Faceit nicknames';

    public function handle(): void
    {
        $message = $this->getUpdate()->getMessage();
        $chatId = $message->getChat()->getId();
        $userId = $message->getFrom()->getId();



        $this->replyWithMessage(['text' => "idi nahui"]);
    }

}
