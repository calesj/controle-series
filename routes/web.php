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

use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/series', 'SeriesController@index')->name('listar_series');
Route::get('/series/criar', 'SeriesController@create')
    ->name('form_criar_serie')->middleware('autenticador');
Route::post('/series/criar', 'SeriesController@store')->middleware('autenticador');
Route::delete('/series/{id}', 'SeriesController@destroy')->middleware('autenticador');

Route::get('/series/{serieid}/temporadas', 'TemporadasController@index');
Route::get('/temporadas/{temporada}/episodios', 'EpisodiosController@index');
Route::post('/temporadas/{temporada}/episodios/assistir', 'EpisodiosController@assistir')->middleware('autenticador');

Route::post('/series/{id}/editaNome', 'SeriesController@editaNome')->middleware('autenticador');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/entrar', 'EntrarController@index');
Route::post('/entrar', 'EntrarController@entrar');

Route::get('/registrar', 'RegistroController@create');

Route::post('/registrar', 'RegistroController@store');

Route::get('/sair', function () {

    Auth::logout();
    return redirect('/entrar');
});
Route::get('/enviando-email', function () {
    $email = new \App\Mail\NovaSerie(
        'Arrow',
        22,
        22);
    $user = (object)['email' => 'cales.junior32@gmail.com',
             'name' => 'Cales'];
    Mail::to($user)->send($email);

    return 'Email Enviado';
});Route::get('/visualizando-email', function () {
    return new \App\Mail\NovaSerie(
        'Arrow',
        22,
        22);
});

