<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailMessageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
if (env('APP_ENV') == 'local' && filter_var(env('LOCAL_AUTO_LOGIN', true), FILTER_VALIDATE_BOOLEAN)) {
    Auth::loginUsingId(1,true);
}

Route::get('/login',[\App\Http\Controllers\authentications\LoginBasic::class,'index'])->name('login');

Route::post('/logout', function () {
   return redirect(env('LOGOUT_URL'));
})->name('logout');

Route::get('/logout', function () {
   return redirect(env('LOGOUT_URL'));
})->name('logout');

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('billiards', App\Http\Controllers\BilliardController::class);
    Route::post('/billiard_rates', [App\Http\Controllers\BilliardController::class,'billiard_rates']);
    Route::resource('rates', App\Http\Controllers\RateController::class);
    Route::resource('orders', App\Http\Controllers\OrderController::class);

    Route::resource('consumers', App\Http\Controllers\ConsumerController::class);
    Route::post('consumers_unique', [\App\Http\Controllers\ConsumerController::class,'consumers_unique']);

    Route::post('order_status', [\App\Http\Controllers\OrderController::class,'order_status'])->name('order_status');

    Route::resource('tags', App\Http\Controllers\TagController::class);
    Route::resource('faqs', App\Http\Controllers\FaqController::class);
    Route::resource('langs', App\Http\Controllers\LangController::class);

    Route::get('/mail-messages', [MailMessageController::class, 'index'])->name('mail-messages.index');;
    Route::put('/mail-messages/{id}/status', [MailMessageController::class, 'updateStatus']);
    Route::delete('/mail-messages/{id}', [MailMessageController::class, 'destroy'])->name('mail-messages.destroy');

});
