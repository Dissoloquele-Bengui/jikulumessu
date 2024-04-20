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
    return redirect('/sgcf/site/index');
});
Route::prefix('sgcf/site')->group(function () {
    //Rota de listar
    Route::get('index', ['as' => 'sgcf.site.index', 'uses' => 'Site\SiteController@index']);
   //Rota para ver detalhes do restaurante
    Route::get('restaurante/{id}', ['as' => 'sgcf.site.restaurante', 'uses' => 'Site\SiteController@restaurante']);
    Route::get('getHospital', ['as' => 'sgcf.site.getHospitalByTipoConsulta', 'uses' => 'Site\SiteController@getHospitalByTipoConsulta']);
    //Rota para ver todos os restaurante

    Route::get('campeonatos', ['as' => 'sgcf.site.campeonatos', 'uses' => 'Site\SiteController@campeonatos']);
    Route::get('classificacao/{id}', ['as' => 'sgcf.site.classificacao', 'uses' => 'Site\SiteController@classificacao']);
    Route::get('calendario/{id}', ['as' => 'sgcf.site.calendario', 'uses' => 'Site\SiteController@calendario']);
    Route::get('resultado/{id}', ['as' => 'sgcf.site.resultado', 'uses' => 'Site\SiteController@resultado']);
    Route::get('gols/{id}', ['as' => 'sgcf.site.gols', 'uses' => 'Site\SiteController@gols']);
    Route::get('assistencias/{id}', ['as' => 'sgcf.site.assistencias', 'uses' => 'Site\SiteController@assistencias']);
    Route::get('equipas/{id}', ['as' => 'sgcf.site.equipas', 'uses' => 'Site\SiteController@equipas']);
    Route::get('jogadores/{id}', ['as' => 'sgcf.site.jogadores', 'uses' => 'Site\SiteController@jogadores']);


    Route::post('search', ['as' => 'sgcf.site.search', 'uses' => 'Site\SiteController@search']);
 
    //Rota para abrir a página de sobre
    Route::get('sobre', ['as' => 'sgcf.site.sobre', 'uses' => 'Site\SiteController@sobre']);
    Route::fallback(function(){
        return view('site.404');
    });

});
Route::prefix('dog/site')->middleware('auth')->group(function () {
    //Rota que leva a página de compras
    Route::post('compra', ['as' => 'sgcf.site.compra', 'uses' => 'Site\SiteController@compra']);
    Route::post('charge', ['as' => 'charge', 'uses' => 'Site\PagamentoController@charge']);
    Route::get('success', ['as' => 'sgcf.site.success', 'uses' => 'Site\PagamentoController@success']);
    Route::get('error', ['as' => 'sgcf.site.error', 'uses' => 'Site\PagamentoController@error']);
    Route::get('gerarGuia/{id}', ['as' => 'sgcf.site.gerarGuia', 'uses' => 'Site\PagamentoController@gerarGuia']);
    Route::post('efectuarPagamento/{id}', ['as' => 'sgcf.site.efectuarPagamento', 'uses' => 'Site\PagamentoController@efectuarPagamento']);
    //Rota para comentar
    Route::post('comentarios', ['as' => 'sgcf.site.comentarios', 'uses' => 'Site\SiteController@comentarios']);


    //Rota para gerar facturas
    Route::post('checkout', ['as' => 'sgcf.site.checkout', 'uses' => 'Site\SiteController@checkout']);
    //Rota para ver o tabuleiro
    Route::get('tabuleiro', ['as' => 'sgcf.site.tabuleiro', 'uses' => 'Site\SiteController@tabuleiro']);

    //Rota para actualizar o tabuleiro
    Route::post('updateTabuleiro', ['as' => 'sgcf.site.updateTabuleiro', 'uses' => 'Site\SiteController@updateTabuleiro']);

    //Rota para adicionar um prato ao carrinho
    Route::get('addPratoCart/{id}', ['as' => 'sgcf.site.addPratoCart', 'uses' => 'Site\SiteController@addPratoCart']);
    //Rota para remover um prato do carrinho
    Route::get('removePratoCart/{id}', ['as' => 'sgcf.site.removePratoCart', 'uses' => 'Site\SiteController@removePratoCart']);
    //Rota para avaliar um prato
    Route::get('avaliarPrato', ['as' => 'sgcf.site.avaliarPrato', 'uses' => 'Site\SiteController@avaliarPrato']);

});
Route::prefix('dog/site/user')->middleware('auth')->group(function () {
    //Rota para acessar o perfil do usuário
    Route::get('perfil', ['as' => 'sgcf.site.perfil', 'uses' => 'Site\UserController@perfil']);
    //Rota para listar as facturas do usuário
    Route::get('faturas', ['as' => 'sgcf.site.faturas', 'uses' => 'Site\UserController@faturas']);
    //Rota para actualizar o perfil do usuário
    Route::post('perfil', ['as' => 'sgcf.site.editar', 'uses' => 'Site\UserController@edit']);
    //Rota para imprimir a fatura
    Route::get('fatura/{id}', ['as' => 'sgcf.site.fatura', 'uses' => 'Site\UserController@fatura']);

});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    return redirect("dashboard");
});

Route::middleware('auth')->get('/dashboard', ['as'=> 'dashboard', 'uses' => 'Admin\DashboardController@dashboard']);
