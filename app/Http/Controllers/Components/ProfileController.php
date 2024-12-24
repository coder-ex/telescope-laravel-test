<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Получить все профили [GET]
     * 
     */
    public function index()
    {
        $result = (new ProfileService())->getAll();

        return response()->json([
            'success' => true,
            'result'  => $result,
        ]);
    }

    /**
     * Создать профиль [ROST]
     * 
     * @param Request $request
     * 
     * @return string
     */
    public function addProfile(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'nullable|string',
                'last_name'  => 'nullable|string',
                'birthday'   => 'nullable|string',
                'email'      => 'required|unique:profiles|string',
                'telegram'   => 'required|unique:profiles|string',
                'phone'      => 'required|unique:profiles|string',
            ]);

            $result = (new ProfileService())->add($validated);

            return response()->json([
                'success' => true,
                'result'  => $result,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Получить данные профиля по id [GET]
     * 
     * @param int $profile_id
     * 
     * @return string
     */
    public function getProfile(int $profile_id)
    {
        try{
            $result = (new ProfileService())->getOne($profile_id);

            return response()->json([
                'success' => true,
                'result'  => $result,
            ]);
        }catch(\Throwable $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Редактировать профиль [PUT]
     * 
     * @param Request $request
     * 
     * @return string
     */
    public function editProfile(Request $request)
    {
        try {
            $validated = $request->validate([
                'id'         => 'required|numeric',
                'first_name' => 'nullable|string',
                'last_name'  => 'nullable|string',
                'birthday'   => 'nullable|string',
                'email'      => 'nullable|string',
                'telegram'   => 'nullable|string',
                'phone'      => 'nullable|string',
            ]);

            $result = (new ProfileService())->edit($validated);

            return response()->json([
                'success' => true,
                'result'  => $result,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
