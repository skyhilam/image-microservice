<?php

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

$router->get('/', function() {
    return 'v1.0.0';
});


$router->post('/copy', 'ImageController@copy');
$router->post('/file', 'ImageController@store');
$router->post('/exists', 'ImageController@exists');
$router->delete('/file', 'ImageController@destroy');

$router->get('/{folder}/{filename}', 'ImageController@show');


