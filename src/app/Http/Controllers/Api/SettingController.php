<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return Setting::getAllSettings();
    }

    public function group($group)
    {
        return Setting::getGroup($group);
    }

    public function show($key)
    {
        $value = Setting::get($key);
        
        if ($value === null) {
            return response()->json(['message' => 'Setting not found'], 404);
        }

        return ['key' => $key, 'value' => $value];
    }
}
