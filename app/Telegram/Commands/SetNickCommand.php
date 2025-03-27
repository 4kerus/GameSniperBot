<?php

namespace App\Telegram\Commands;

use App\Models\Chat;
use App\Models\TelegramUser;
use App\Services\FaceitService;
use App\Services\TelegramService;
use Telegram\Bot\Commands\Command;
use function PHPUnit\Framework\isFalse;

class SetNickCommand extends Command
{
    protected string $name = 'set';
    protected string $description = 'Assign a Faceit nickname to a user in chat';

    public function handle(): void
    {
        $message = $this->getUpdate()->getMessage();
        $chatId = $message->getChat()->getId();
        $userId = $message->getFrom()->getId();
        $replyToMessage = $message->getReplyToMessage();

        $nick = trim(str_replace('/set', '', $message->getText()));

//        $this->replyWithMessage([
//            'text' => $nick,
//        ]);

        if (empty($nick)) {
            $this->replyWithMessage(['text' => 'Usage: /set <Faceit_nickname>']);
            return;
        }

        $chat = Chat::firstOrCreate(['tg_chat_id' => $chatId]);


        $user = TelegramUser::firstOrCreate(['telegram_id' => $userId], [
            'first_name' => $message->getFrom()->getFirstName(),
            'last_name' => $message->getFrom()->getLastName(),
            'username' => $message->getFrom()->getUsername(),
        ]);

        if ($replyToMessage) {
            $repliedUserId = $replyToMessage->getFrom()->getId();
            $repliedUser = TelegramUser::firstOrCreate(['telegram_id' => $repliedUserId], [
                'first_name' => $replyToMessage->getFrom()->getFirstName(),
                'last_name' => $replyToMessage->getFrom()->getLastName(),
                'username' => $replyToMessage->getFrom()->getUsername(),
            ]);

            $isAdmin = (new TelegramService())->isUserAdmin($chatId, $userId);

            if ($isAdmin) {
                (new FaceitService())->setUserNickInChat($repliedUser, $chat, $nick);
                $this->replyWithMessage([
                    'text' => "Faceit nickname '{$nick}' assigned to {$repliedUser->first_name}.",
                ]);
                return;
            } else {
                $this->replyWithMessage([
                    'text' => "Only admins can assign nicknames to others.",
                ]);
                return;
            }
        }


        (new FaceitService())->setUserNickInChat($user, $chat, $nick);
        $this->replyWithMessage([
            'text' => "Your Faceit nickname '{$nick}' has been set.",
        ]);
    }
}
