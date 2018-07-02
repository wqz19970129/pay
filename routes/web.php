<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home',function (){
    return '继续充值';
})->name('home');

Route::get('/pay','PayController@index');

Route::get('/payment','PaymentController@index');
Route::post('/payment','PaymentController@index');
Route::post('/pay','PayController@enter')->name('inters');

//Route::post('/pay','PayController@create')->name('store');
//Route::post('/pay','PayController@notify')->name('notify');

Route::any('/result/{id}',function ($id){
       $order=DB::table('pays')->value('result_pay');
       //var_dump($order);
    if($order == 'SUCCESS'){

    }
});

