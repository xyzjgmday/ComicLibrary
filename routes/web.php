<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/genres', 'GenreController@index');
    $router->get('/genres/{id}', 'GenreController@show');
    $router->post('/genres', 'GenreController@create');
    $router->put('/genres/{id}', 'GenreController@update');
    $router->delete('/genres/{id}', 'GenreController@destroy');

    $router->get('/readers', 'ReaderController@index');
    $router->get('/readers/{id}', 'ReaderController@show');
    $router->post('/readers', 'ReaderController@create');
    $router->put('/readers/{id}', 'ReaderController@update');
    $router->delete('/readers/{id}', 'ReaderController@destroy');

    $router->get('/comics', 'ComicController@index');
    $router->get('/comics/{id}', 'ComicController@show');
    $router->post('/comics', 'ComicController@create');
    $router->put('/comics/{id}', 'ComicController@update');
    $router->delete('/comics/{id}', 'ComicController@destroy');
});

