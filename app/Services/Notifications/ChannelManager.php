<?php

namespace App\Services\Notifications;

use App\Interfaces\IChannelManager;

abstract class ChannelManager implements IChannelManager
{
    public $channel_name;

    public function __construct(string $channel_name)
    {
        $this->channel_name = $channel_name;
    }

    public function handle(string $content)
    {
        $payload = [
            'message' => $content,
        ];

        $this->sendPayload($payload);
    }

    abstract protected function sendPayload(array $payload);
}