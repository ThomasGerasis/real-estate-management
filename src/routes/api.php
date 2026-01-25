<?php

use App\Http\Controllers\Api\AgentController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    
    // Properties
    Route::get('/properties', [PropertyController::class, 'index']);
    Route::get('/properties/featured', [PropertyController::class, 'featured']);
    Route::get('/properties/search', [PropertyController::class, 'search']);
    Route::get('/properties/{id}', [PropertyController::class, 'show']);
    Route::get('/properties/{id}/similar', [PropertyController::class, 'similar']);
    
    // Agents
    Route::get('/agents', [AgentController::class, 'index']);
    Route::get('/agents/{id}', [AgentController::class, 'show']);
    
    // Posts/Blog
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/latest', [PostController::class, 'latest']);
    Route::get('/posts/{slug}', [PostController::class, 'show']);
    
    // Pages
    Route::get('/pages', [PageController::class, 'index']);
    Route::get('/pages/{slug}', [PageController::class, 'show']);
    
    // Cities & Districts
    Route::get('/cities', [CityController::class, 'index']);
    Route::get('/cities/{id}', [CityController::class, 'show']);
    Route::get('/cities/{id}/districts', [CityController::class, 'districts']);
    
    // Menus
    Route::get('/menu', [MenuController::class, 'all']);
    Route::get('/menu/header', [MenuController::class, 'header']);
    Route::get('/menu/footer', [MenuController::class, 'footer']);
    
    // Settings
    Route::get('/settings', [SettingController::class, 'index']);
    Route::get('/settings/group/{group}', [SettingController::class, 'group']);
    Route::get('/settings/{key}', [SettingController::class, 'show']);
    
    // Contact Forms
    Route::post('/contact', [ContactController::class, 'submit']);
    Route::post('/property-inquiry', [ContactController::class, 'submitPropertyInquiry']);
});
