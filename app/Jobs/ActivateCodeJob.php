<?php

namespace App\Jobs;

use App\Services\Notifications\ChannelManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ActivateCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Создать новый экземпляр задания
     */
    public function __construct(private ChannelManager $instance, private string $message) {}

    /**
     * Выполнить задание
     */
    public function handle(): void
    {
        try {
            $this->instance->handle($this->message);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
        }
    }
}
