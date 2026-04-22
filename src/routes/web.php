<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/contact', [App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');
Route::post('/property-inquiry', [App\Http\Controllers\ContactController::class, 'submitPropertyInquiry'])->name('contact.property-inquiry');
Route::post('/inquiry', [App\Http\Controllers\ContactController::class, 'submitGeneralInquiry'])->name('contact.inquiry');
Route::post('/mandate', [App\Http\Controllers\ContactController::class, 'submitMandate'])->name('contact.mandate');

Route::get('/admin/switch-locale/{locale}', function ($locale) {
    if (in_array($locale, ['el', 'en'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('filament.admin.switch-locale');
