<?php

namespace App\Telegram\Commands;

use JsonException;
use Telegram\Bot\Commands\Command;

class GetEloCommand extends Command
{
    protected string $name = 'elo';

    protected string $description = 'Get Elo rating for a specific nickname';

    public function handle(): void
    {
        $message = $this->getUpdate()->getMessage()->getText();

        $parts = explode(' ', $message);

        if (count($parts) < 2 || empty(trim($parts[1]))) {
            $this->replyWithMessage([
                'text' => 'Укажите /elo nickname',
            ]);
            return;
        }

        $nick = trim($parts[1]);
        $text = "{$nick} - 7 lvl 1200 elo";

        $this->replyWithMessage([
            'text' => $text,
            'reply_markup' => $this->buildKeyboard(),
        ]);
    }

    private function buildKeyboard(): false|string
    {
        return json_encode([
            'inline_keyboard' => [
                [
                    ['text' => 'Latest matches', 'callback_data' => 'latest_matches']
                ]
            ]
        ], JSON_THROW_ON_ERROR);
    }
}
