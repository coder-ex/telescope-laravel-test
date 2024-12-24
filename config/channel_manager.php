<?php

use App\Services\Notifications\EmailChannelManager;
use App\Services\Notifications\TelegramChannelManager;

return [
    'TG' => [
        'manager' => TelegramChannelManager::class,
        'bots'    => [
            'TG_NOTIFY_BOT_1' => [
                'bot'     => 'BarbarianEventHome_bot',
                'token'   => env('TELEGRAM_BOT_TOKEN'),
                'chat_id' => '',                          //'-1002098437848',
            ],
        ],
    ],
    'EMAIL' => [
        'manager' => EmailChannelManager::class,
    ],
    'SMS' => [
        //
    ],
];
