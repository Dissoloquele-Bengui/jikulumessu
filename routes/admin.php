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





Route::prefix('campeonato')->group(function () {
    //Rota de listar
    Route::get('index', ['as' => 'admin.campeonato.index', 'uses' => 'Admin\CampeonatoController@index']);
    //Rota para armazenar
    Route::post('store', ['as' => 'admin.campeonato.store', 'uses' => 'Admin\CampeonatoController@store']);
    //Rota para actualizar
    Route::post('update/{id}', ['as' => 'admin.campeonato.update', 'uses' => 'Admin\CampeonatoController@update']);
    //Rota para marcar como eliminado
    Route::get('destroy/{id}', ['as' => 'admin.campeonato.destroy', 'uses' => 'Admin\CampeonatoController@destroy']);
    //Rota de eliminar/purgar
    Route::get('purge/{id}', ['as' => 'admin.campeonato.purge', 'uses' => 'Admin\CampeonatoController@purge']);
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




Route::get('/data', ['as'=> 'admin.dashboard.graficos', 'uses' => 'Admin\DashboardController@graficos']);

Route::prefix('log')->group(function () {
        //Rota para listar as actividades

    Route::get('index', ['as' => 'admin.logs.index', 'uses' => 'Admin\LogController@index']);
});

Route::prefix('epoca')->group(function () {
    Route::get('index', ['as' => 'admin.epoca.index', 'uses' => 'Admin\EpocaController@index']);
    Route::get('create', ['as' => 'admin.epoca.create', 'uses' => 'Admin\EpocaController@create']);
    Route::post('store', ['as' => 'admin.epoca.store', 'uses' => 'Admin\EpocaController@store']);
    Route::get('show/{id}', ['as' => 'admin.epoca.show', 'uses' => 'Admin\EpocaController@show']);
    Route::get('edit/{id}', ['as' => 'admin.epoca.edit', 'uses' => 'Admin\EpocaController@edit']);
    Route::post('update/{id}', ['as' => 'admin.epoca.update', 'uses' => 'Admin\EpocaController@update']);
    Route::get('destroy/{id}', ['as' => 'admin.epoca.destroy', 'uses' => 'Admin\EpocaController@destroy']);
    Route::get('purge/{id}', ['as' => 'admin.epoca.purge', 'uses' => 'Admin\EpocaController@purge']);

});
Route::prefix('equipa')->group(function () {
    Route::get('index', ['as' => 'admin.equipa.index', 'uses' => 'Admin\EquipaController@index']);
    Route::get('create', ['as' => 'admin.equipa.create', 'uses' => 'Admin\EquipaController@create']);
    Route::post('store', ['as' => 'admin.equipa.store', 'uses' => 'Admin\EquipaController@store']);
    Route::get('show/{id}', ['as' => 'admin.equipa.show', 'uses' => 'Admin\EquipaController@show']);
    Route::get('edit/{id}', ['as' => 'admin.equipa.edit', 'uses' => 'Admin\EquipaController@edit']);
    Route::post('update/{id}', ['as' => 'admin.equipa.update', 'uses' => 'Admin\EquipaController@update']);
    Route::get('destroy/{id}', ['as' => 'admin.equipa.destroy', 'uses' => 'Admin\EquipaController@destroy']);
    Route::get('purge/{id}', ['as' => 'admin.equipa.purge', 'uses' => 'Admin\EquipaController@purge']);

});

Route::prefix('jogador')->group(function () {
    Route::get('index', ['as' => 'admin.jogador.index', 'uses' => 'Admin\JogadorController@index']);
    Route::get('create', ['as' => 'admin.jogador.create', 'uses' => 'Admin\JogadorController@create']);
    Route::post('store', ['as' => 'admin.jogador.store', 'uses' => 'Admin\JogadorController@store']);
    Route::get('show/{id}', ['as' => 'admin.jogador.show', 'uses' => 'Admin\JogadorController@show']);
    Route::get('edit/{id}', ['as' => 'admin.jogador.edit', 'uses' => 'Admin\JogadorController@edit']);
    Route::post('update/{id}', ['as' => 'admin.jogador.update', 'uses' => 'Admin\JogadorController@update']);
    Route::get('destroy/{id}', ['as' => 'admin.jogador.destroy', 'uses' => 'Admin\JogadorController@destroy']);
    Route::get('purge/{id}', ['as' => 'admin.jogador.purge', 'uses' => 'Admin\JogadorController@purge']);

});

Route::prefix('campeonato_equipa')->group(function () {
    Route::get('index', ['as' => 'admin.campeonato_equipa.index', 'uses' => 'Admin\CampeonatoEquipaController@index']);
    Route::get('create', ['as' => 'admin.campeonato_equipa.create', 'uses' => 'Admin\CampeonatoEquipaController@create']);
    Route::post('store', ['as' => 'admin.campeonato_equipa.store', 'uses' => 'Admin\CampeonatoEquipaController@store']);
    Route::get('show/{id}', ['as' => 'admin.campeonato_equipa.show', 'uses' => 'Admin\CampeonatoEquipaController@show']);
    Route::get('edit/{id}', ['as' => 'admin.campeonato_equipa.edit', 'uses' => 'Admin\CampeonatoEquipaController@edit']);
    Route::post('update/{id}', ['as' => 'admin.campeonato_equipa.update', 'uses' => 'Admin\CampeonatoEquipaController@update']);
    Route::get('destroy/{id}', ['as' => 'admin.campeonato_equipa.destroy', 'uses' => 'Admin\CampeonatoEquipaController@destroy']);
    Route::get('purge/{id}', ['as' => 'admin.campeonato_equipa.purge', 'uses' => 'Admin\CampeonatoEquipaController@purge']);

});
Route::prefix('jogo')->group(function () {
    Route::get('index', ['as' => 'admin.jogo.index', 'uses' => 'Admin\JogoController@index']);
    Route::get('create', ['as' => 'admin.jogo.create', 'uses' => 'Admin\JogoController@create']);
    Route::post('store', ['as' => 'admin.jogo.store', 'uses' => 'Admin\JogoController@store']);
    Route::get('getDataByCampeonato', ['as' => 'admin.jogo.getDataByCampeonato', 'uses' => 'Admin\JogoController@getDataByCampeonato']);
    Route::get('show/{id}', ['as' => 'admin.jogo.show', 'uses' => 'Admin\JogoController@show']);
    Route::get('edit/{id}', ['as' => 'admin.jogo.edit', 'uses' => 'Admin\JogoController@edit']);
    Route::post('update/{id}', ['as' => 'admin.jogo.update', 'uses' => 'Admin\JogoController@update']);
    Route::post('update_result/{id}', ['as' => 'admin.jogo.update_result', 'uses' => 'Admin\JogoController@update_result']);
    Route::get('add_gol_field', ['as' => 'admin.jogo.add_gol_field', 'uses' => 'Admin\JogoController@add_gol_field']);
    Route::get('add_assistencia_field/', ['as' => 'admin.jogo.add_assistencia_field', 'uses' => 'Admin\JogoController@add_assistencia_field']);
    Route::get('remove_gol', ['as' => 'admin.jogo.remove_gol', 'uses' => 'Admin\JogoController@remove_gol']);
    Route::get('remove_assistencia', ['as' => 'admin.jogo.remove_assistencia', 'uses' => 'Admin\JogoController@remove_assistencia']);
    Route::get('destroy/{id}', ['as' => 'admin.jogo.destroy', 'uses' => 'Admin\JogoController@destroy']);
    Route::get('purge/{id}', ['as' => 'admin.jogo.purge', 'uses' => 'Admin\JogoController@purge']);

});

