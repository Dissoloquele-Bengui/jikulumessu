<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function(){
    return redirect('/sgv/site/index');
});

Route::prefix('/api/carro')->group(function () {
    //Rota de listar

    Route::get('/updateLocalizar/{id}/{latitude}/{longitude}', ['as' => 'admin.carro.updateLocalizar', 'uses' => 'Admin\CarroController@updateLocalizar']);

    Route::get('/localizar/{id}', ['as' => 'admin.carro.localizar', 'uses' => 'Admin\CarroController@localizar']);
    Route::get('/getLocalizacao/{id}', ['as' => 'admin.carro.getLocalizacao', 'uses' => 'Admin\CarroController@getLocalizacao']);

});

Route::prefix('/api/people')->group(function () {

    Route::get('/updateLocalizar/{id}/{password}/{latitude}/{longitude}/{velocidade}', ['as' => 'admin.user.updateLocalizar', 'uses' => 'Admin\UserController@updateLocalizar']);

    Route::get('/localizar/{id}', ['as' => 'admin.user.localizar', 'uses' => 'Admin\UserController@localizar']);

    Route::get('/contactos/{id}/{password}', ['as' => 'admin.user.contactos', 'uses' => 'Admin\UserController@contactos']);

    Route::get('/getLocalizacao/{id}', ['as' => 'admin.people.getLocalizacao', 'uses' => 'Admin\UserController@getLocalizacao']);


});
Route::get('getEmail', ['as' => 'admin.user.getEmail', 'uses' => 'Site\UserController@getEmail']);
Route::prefix('sgv/site')->group(function () {
    //Rota de listar
    Route::get('index', ['as' => 'sgv.site.index', 'uses' => 'Site\SiteController@index']);
    Route::get('localizar', ['as' => 'sgv.site.localizar', 'uses' => 'Site\SiteController@localizar']);
    Route::get('people', ['as' => 'sgv.site.people', 'uses' => 'Site\SiteController@people']);
    Route::get('cars', ['as' => 'sgv.site.cars', 'uses' => 'Site\SiteController@cars']);

    Route::fallback(function(){
        return view('site.404');
    });





});

Route::middleware('auth')->get('login3', ['as' => 'sgv.site.login', 'uses' => 'Site\SiteController@login']);
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    return redirect()->route('sgv.site.login');
});


Route::middleware('auth')->get('/dashboard', ['as'=> 'dashboard', 'uses' => 'Admin\DashboardController@dashboard']);
