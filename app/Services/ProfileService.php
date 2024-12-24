<?php

namespace App\Services;

use App\Models\Profile;
use Carbon\Carbon;

class ProfileService
{

    /**
     * Получить список всех профилей
     * 
     * @return mixed
     */
    public function getAll()
    {
        $data = Profile::all();

        return $data->map(function ($profile) {
            return $this->_serialize($profile);
        });
    }

    /**
     * Добавить профиль
     * 
     * @param array $validated массив входных параметров
     * 
     * @return array
     */
    public function add(array $validated)
    {
        $candidate = Profile::create($validated);
        return $this->_serialize($candidate);
    }

    /**
     * Получить профиль
     * 
     * @param int $profile_id id профиля
     * 
     * @return mixed
     */
    public function getOne(int $profile_id)
    {
        $profile = Profile::query()->where('id', $profile_id)->first();

        if (is_null($profile)) {
            throw new \Exception("Профиль по id [{$profile_id}] не найден");
        }

        //---
        return $this->_serialize($profile);
    }

    /**
     * Редактировать профиль
     * 
     * @return mixed
     */
    public function edit(array $validated)
    {
        if (!$this->_validateAddData($validated)) {
            throw new \Exception('Нет данных для изменения !!');
        }

        $candidate = Profile::where('id', $validated['id'])->first();

        if(is_null($candidate)){
            throw new \Exception("По id {$validated['id']} профиль не найден, это ошибка !!");
        }

        $candidate->update($validated);

        return $this->_serialize($candidate);
    }

    //=============== PRIVATE METHODS ===============//

    /**
     * Сериализация данных профиля
     * 
     * @param Profile $instanse инстанс Модели Profile
     * 
     * @return array
     */
    private function _serialize(Profile $instanse)
    {
        return [
            'id'         => $instanse['id'],
            'first_name' => $instanse['first_name'] ?? '',
            'last_name'  => $instanse['last_name'] ?? '',
            'birthday'   => $instanse['birthday'] ?? '',
            'email'      => $instanse['email'],                // т.к. это поле при создании обязательно
            'telegram'   => $instanse['telegram'] ?? '',
            'phone'      => $instanse['phone'] ?? '',
            'created_at' => Carbon::parse($instanse['created_at'], 'Asia/Tomcs'),
        ];
    }

    /**
     * Валидация при редактировании
     * 
     * @param array $validated
     * 
     * @return bool
     */
    private function _validateAddData(array $validated)
    {
        if (
            empty($validated['first_name']) &&
            empty($validated['last_name']) &&
            empty($validated['birthday']) &&
            empty($validated['email']) &&
            empty($validated['telegram']) &&
            empty($validated['phone'])
        ) {
            return false;
        }
        //---
        return true;
    }
}
