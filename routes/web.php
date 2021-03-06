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

$router
->get('/', function () use ($router) {
    return redirect('api/docs');
})
//the endpoints of the API
->get('/houses', ['uses' => 'HouseController@index'])
->get('/characters', ['uses' => 'CharacterController@index'])
->get('/characters/{id}', ['uses' => 'CharacterController@show'])
->post('/characters', ['uses' => 'CharacterController@store'])
->delete('/characters/{id}', ['uses' => 'CharacterController@destroy'])
->put('/characters/{id}', ['uses' => 'CharacterController@update'])
->post('/characters/{id}/restore', ['uses' => 'CharacterController@restore']);
