<?php

namespace App\Services;

use App\Jobs\ActivateCodeJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Notification
{
    const EXP_TTL = 300;  // экспирация 5 минут

    const NAME_CACHE = 'notification_confirmation_code';

    public function __construct(private string $channel_name = '', private string $account = '') {}

    /**
     * Отправка сообщения в канал
     * 
     * @return bool
     */
    public function send($payload): bool
    {
        $class   = config("channel_manager.{$this->channel_name}.manager");
        $message = $this->_generateCode($payload);

        dispatch(new ActivateCodeJob(new $class($this->channel_name, $this->account), $message));

        return true;
    }

    //=============== PRIVATE METHODS ===============//

    /**
     * Генератор кода подтверждения для отправки
     * 
     * @return string
     */
    private function _generateCode($payload)
    {
        $_data['payload'] = $payload;
        $_data['code']    = rand(1000, 9999);
        $current_ts       = Carbon::now('Asia/Tomsk');
        $data             = json_encode($_data, JSON_UNESCAPED_UNICODE);

        Cache::set(self::NAME_CACHE, ['data' => $data, 'current_ts' => $current_ts], self::EXP_TTL);

        return $_data['code'];
    }
}

/*
1. генерируем код и фиксируем время [OK]
2. записываем код/время в кэшь      [OK]
3. отправляем код в канал           [OK]
4. получаем код запросом, смотрим время (время экспирации 5 минут)
5. проверяем код и экспирацию кода
6. если п.5==ОК то true, иначе false
*/
