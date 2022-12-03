<?php

use App\Http\Controllers\Api;
use App\Models\BookingAgency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('channex')->middleware('auth:sanctum')->group(function(){
    Route::post('new-reservation', [Api\ChannexReservationController::class, 'store']);
});

Route::get('/engine-bg/{id}', function (Request $request, $id) {
    $path = BookingAgency::select('bg')->where('channex_channel_id', $id)->first()->bg;
    return  Image::make($path)->response();
});
