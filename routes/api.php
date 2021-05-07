<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\CurrenciesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix("v1")->namespace("v1")->group(function() {
    Route::prefix("/currencies")->group(function() {
        Route::get('/{date?}', [CurrenciesController::class, 'getCurrencies'])
        ->where('date', '[0-9]{4}(?:[\-][0-9]{2}){2}')
        ->name('get_currencies');

        Route::get('/{char_code}/{date?}', [CurrenciesController::class, 'getCurrency'])
        ->where('char_code', '[A-Z]*')
        ->where('date', '[0-9]{4}(?:[\-][0-9]{2}){2}')
        ->name('get_currency');

        Route::patch('/{id}', [CurrenciesController::class, 'saveDescribeCurrency'])
        ->where('id', '[0-9]*')
        ->name('save_describe_currency');
    });
});
