<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('users','UsersController@store');

Route::group(['middleware'=>'auth:api'], function(){
    Route::get('users','UsersController@index');
    Route::put('users','UsersController@update');
    Route::delete('users','UsersController@destroy');
    Route::apiResource('invoices','InvoicesController');
    Route::apiResource('categorys','CategoryController');
    Route::apiResource('invoicedetails','InvoiceDetailsController');
    Route::apiResource('products','ProductsController');
    Route::apiResource('userstypes','UsersTypeController');
});
