<?php

namespace App\Services\Notifications;

use Illuminate\Support\Facades\Http;
use Telegram\Bot\Api;

class TelegramChannelManager extends ChannelManager
{
    private $chat_id;
    private $token;

    public function __construct(string $channel_name, string $account)
    {
        parent::__construct($channel_name);
        
        [$this->chat_id, $this->token] = $this->_getChatId($account);
    }

    protected function sendPayload(array $payload)
    {
        $telegram = new Api($this->token);
        try {
            $telegram->sendMessage([
                'chat_id' => $this->chat_id,
                'text'    => $payload['message'],
            ]);
        } catch (\Throwable $e) {
            throw new \Exception('Ошибка при отправке сообщения: ' . $e->getMessage());
        }
    }

    //=============== PRIVATE METHODS ===============//

    /**
     * Получить chat_id пользователя
     * 
     * @param string $account аккаунт пользователя по которому ищем chat_id
     * 
     * @return mixin
     */
    private function _getChatId(string $account)
    {
        $config = config('channel_manager.TG.bots')['TG_NOTIFY_BOT_1'] ?? null;
        if (is_null($config)) {
            throw new \Exception('Телеграм бот не настроен !!');
        }

        $response = Http::get("https://api.telegram.org/bot{$config['token']}/getUpdates");

        if (!$response->ok()) {
            throw new \Exception('Данных нет !!');
        }

        $tg_bot_data = $response->json()['result'];
        $user_data   = [];
        foreach ($tg_bot_data as $item) {
            $chat = $item['message']['chat'] ?? null;
            if ($chat) {
                $user_data[$chat['username']] = [
                    'chat_id'    => $chat['id'],
                    'first_name' => $chat['first_name'] ?? null,
                    'last_name'  => $chat['last_name'] ?? null,
                    'username'   => $chat['username'] ?? null
                ];
            }
        }

        $result = $user_data[$account] ?? null;
        if (is_null($result)) {
            throw new \Exception("Необходимо отправить боту [{$config['bot']}] любое сообщение в Телеграм от имени пользователя [{$account}] !!");
        }

        //---
        return [
            $result['chat_id'],
            $config['token']
        ];
    }
}
