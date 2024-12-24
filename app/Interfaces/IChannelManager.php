<?php

namespace App\Interfaces;

use App\Services\Notications\Notification;

interface IChannelManager
{
    public function handle(string $content);
}
