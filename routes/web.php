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

    $router->get('/readers', 'ReaderController@getAllReaders');
    $router->get('/readers/{id}', 'ReaderController@getReaderById');
    $router->post('/readers', 'ReaderController@createReader');
    $router->put('/readers/{id}', 'ReaderController@updateReader');
    $router->delete('/readers/{id}', 'ReaderController@deleteReader');

    $router->get('/comics', 'ComicController@getAllComics');
    $router->get('/comics/{id}', 'ComicController@getComicById');
    $router->post('/comics', 'ComicController@createComic');
    $router->put('/comics/{id}', 'ComicController@updateComic');
    $router->delete('/comics/{id}', 'ComicController@deleteComic');
});

