<?php

namespace App\Telegram\Commands;

use App\Models\Chat;
use App\Models\TelegramUser;
use App\Services\FaceitService;
use Telegram\Bot\Commands\Command;

class FaceitWhoCommand extends Command
{
    protected string $name = 'faceit_who';
    protected string $description = 'Show Faceit nicknames of a user in the chat and their personal nickname';

    public function handle(): void
    {
        $message = $this->getUpdate()->getMessage();
        $chatId = $message->getChat()->getId();
        $userId = $message->getFrom()->getId();
        $replyToMessage = $message->getReplyToMessage();

        $chat = Chat::firstOrCreate(['tg_chat_id' => $chatId]);

        $targetUserId = $replyToMessage ? $replyToMessage->getFrom()->getId() : $userId;
        $targetUser = TelegramUser::where('telegram_id', $targetUserId)->first();

        if (!$targetUser) {
            $this->replyWithMessage(['text' => 'User not found in the database.']);
            return;
        }

        $faceitService = new FaceitService();
        $chatNick = $faceitService->getNickByUserInChat($targetUser, $chat) ?? 'Not set';

        $myChat = Chat::where(['tg_chat_id' => $targetUser->telegram_id])->first();
        $personalNick = $myChat ? $faceitService->getNickByUserInChat($targetUser, $myChat) : 'Not set';

        $responseText = "User: {$targetUser->first_name} (@{$targetUser->username})\n";
        $responseText .= "Faceit Nick in this chat: {$chatNick}\n";
        $responseText .= "Personal Faceit Nick: {$personalNick}";

        $this->replyWithMessage(['text' => $responseText]);
    }

}
