<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use OpenApi\Attributes as OA;

class SettingController extends Controller
{
    #[OA\Get(
        path: '/settings',
        summary: 'Get all settings',
        tags: ['Settings'],
        responses: [
            new OA\Response(response: 200, description: 'All settings as key-value object', content: new OA\JsonContent(type: 'object')),
        ]
    )]
    public function index()
    {
        return Setting::getAllSettings();
    }

    #[OA\Get(
        path: '/settings/group/{group}',
        summary: 'Get settings by group',
        tags: ['Settings'],
        parameters: [
            new OA\Parameter(name: 'group', in: 'path', required: true, schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Group settings as key-value object', content: new OA\JsonContent(type: 'object')),
        ]
    )]
    public function group($group)
    {
        return Setting::getGroup($group);
    }

    #[OA\Get(
        path: '/settings/{key}',
        summary: 'Get a single setting by key',
        tags: ['Settings'],
        parameters: [
            new OA\Parameter(name: 'key', in: 'path', required: true, schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Setting value', content: new OA\JsonContent(properties: [
                new OA\Property(property: 'key', type: 'string'),
                new OA\Property(property: 'value', type: 'string'),
            ])),
            new OA\Response(response: 404, description: 'Setting not found'),
        ]
    )]
    public function show($key)
    {
        $value = Setting::get($key);

        if ($value === null) {
            return response()->json(['message' => 'Setting not found'], 404);
        }

        return ['key' => $key, 'value' => $value];
    }
}
