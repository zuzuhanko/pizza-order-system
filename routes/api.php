<?php

use App\Models\category;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\API\ApiController;

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

Route::post('register',[AuthController::class,'register']);

Route::post('login',[AuthController::class,'login']);

Route::group(['prefix' => 'category','namespace'=>'API','middleware'=>'auth:sanctum'],function(){
    Route::get('list',[ApiController::class,'categoryList']);//list
    Route::post('create',[ApiController::class,'createList']);//create
    Route::get('details/{id}',[ApiController::class,'categoryDetails']);//details
    Route::get('categoryDelete/{id}',[ApiController::class,'categoryDelete']);//delete
    Route::post('categoryupdate',[ApiController::class,'categoryUpdate']);//update
});

Route::get('pizza',[ApiController::class,'pizza']);

Route::group(['middleware'=>'auth:sanctum'],function(){
   Route::get('logout',[AuthController::class,'logout']);//logout

});

