<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Admin\EmpresaController;

// Route::get('empresas', ['as' => 'admin.empresas', 'uses' => 'Admin\EmpresaController@index']);
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rotas da parte administrativa e de gestão do sistema
|
|
*/





Route::prefix('carro')->group(function () {
    //Rota de listar

    Route::get('index', ['as' => 'admin.carro.index', 'uses' => 'Admin\CarroController@index']);

    Route::post('store', ['as' => 'admin.carro.store', 'uses' => 'Admin\CarroController@store']);
        //Rota de actualizar
    Route::post('update/{id}', ['as' => 'admin.carro.update', 'uses' => 'Admin\CarroController@update']);
        //Rota de marcar como eliminado

    Route::get('destroy/{id}', ['as' => 'admin.carro.destroy', 'uses' => 'Admin\CarroController@destroy']);
    //Rota de eliminar
    Route::get('purge/{id}', ['as' => 'admin.carro.purge', 'uses' => 'Admin\CarroController@purge']);
});
Route::prefix('user')->group(function () {
    //Rota de listar
    Route::get('index', ['as' => 'admin.user.index', 'uses' => 'Admin\UserController@index']);
    //Rota de cadastrar
    Route::post('store', ['as' => 'admin.user.store', 'uses' => 'Admin\UserController@store']);
    //rota de actualizar
    Route::post('update/{id}', ['as' => 'admin.user.update', 'uses' => 'Admin\UserController@update']);
    //rota de marcar como eliminado
    Route::get('destroy/{id}', ['as' => 'admin.user.destroy', 'uses' => 'Admin\UserController@destroy']);
    //rota de eliminar
    Route::get('purge/{id}', ['as' => 'admin.user.purge', 'uses' => 'Admin\UserController@purge']);
});
Route::prefix('funcionario')->group(function () {
    Route::get('index', ['as' => 'admin.user.funcionario', 'uses' => 'Admin\UserController@funcionario']);

});
Route::prefix('cliente')->group(function () {


});
Route::prefix('cliente')->group(function () {
    Route::get('cliente', ['as' => 'admin.user.cliente', 'uses' => 'Admin\UserController@cliente']);
    Route::get('index', ['as' => 'admin.user.proprietario', 'uses' => 'Admin\UserController@proprietario']);

});




Route::get('/data', ['as'=> 'admin.dashboard.graficos', 'uses' => 'Admin\DashboardController@graficos']);

Route::prefix('log')->group(function () {
        //Rota para listar as actividades

    Route::get('index', ['as' => 'admin.logs.index', 'uses' => 'Admin\LogController@index']);
});

Route::prefix('empresa')->group(function () {
    Route::get('index', ['as' => 'admin.empresa.index', 'uses' => 'Admin\EmpresaController@index']);
    Route::get('create', ['as' => 'admin.empresa.create', 'uses' => 'Admin\EmpresaController@create']);
    Route::post('store', ['as' => 'admin.empresa.store', 'uses' => 'Admin\EmpresaController@store']);
    Route::get('show/{id}', ['as' => 'admin.empresa.show', 'uses' => 'Admin\EmpresaController@show']);
    Route::get('edit/{id}', ['as' => 'admin.empresa.edit', 'uses' => 'Admin\EmpresaController@edit']);
    Route::post('update/{id}', ['as' => 'admin.empresa.update', 'uses' => 'Admin\EmpresaController@update']);
    Route::get('destroy/{id}', ['as' => 'admin.empresa.destroy', 'uses' => 'Admin\EmpresaController@destroy']);
    Route::get('purge/{id}', ['as' => 'admin.empresa.purge', 'uses' => 'Admin\EmpresaController@purge']);

});
