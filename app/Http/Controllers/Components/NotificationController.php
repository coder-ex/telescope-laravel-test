<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\Controller;
use App\Services\Notification;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    /**
     * Запрос кода подтверждения [POST]
     * 
     * @param Request $request параметры запроса [account, channel_name, params]
     * 
     * @return string
     */
    public function getCode(Request $request)
    {
        try {
            $validated = $request->validate([
                'account'      => 'required|string',
                'channel_name' => 'required|string',
                'params'       => 'required',
            ]);

            $validated['channel_name'] = \Illuminate\Support\Str::upper($validated['channel_name']);

            (new Notification($validated['channel_name'], $validated['account']))->send($validated['params']);

            return response()->json([
                'success' => true,
                //'result'  => $result ?? null,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Проверка кода подтверждения [POST]
     * 
     * @param Request $request параметры запроса [code]
     * 
     * @return string
     */
    public function checkCode(Request $request)
    {
        $sample = $request->get('code');

        try {
            if (!Cache::has(Notification::NAME_CACHE)) {
                throw new \Exception('Необъяснимая ошибка');
            }

            $data = Cache::get(Notification::NAME_CACHE);
            $data = json_decode($data['data'], true);
            $sample = (int)str_replace(" ", '', $sample);
            if ($sample != (int)$data['code']) {
                throw new \Exception('Код не корректен !!');
            }

            $result = (new ProfileService())->edit($data['payload']);

            return response()->json([
                'success' => true,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
