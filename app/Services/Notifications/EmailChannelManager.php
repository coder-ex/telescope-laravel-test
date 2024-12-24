<?php

namespace App\Services\Notifications;

use Illuminate\Support\Facades\Mail;

class EmailChannelManager extends ChannelManager
{
    private string $subject = 'Код подтверждения';
    private string $email;

    public function __construct(string $channel_name, string $account)
    {
        parent::__construct($channel_name);
        
        $this->email = $account;
    }

    protected function sendPayload(array $payload)
    {
        try {
            Mail::raw($payload['message'], function ($mail) {
                $mail->to($this->email)->subject($this->subject);
            });
        } catch (\Throwable $e) {
            throw new \Exception('Ошибка при отправке сообщения: ' . $e->getMessage());
        }
    }
}