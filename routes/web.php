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

use App\Http\Controllers\API\RotationController;

$router->get('/', function () {
    return view('rotations/index');
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'v1'], function () use ($router) {
        $router->get('rotations', ['uses' => 'API\RotationController@index']);
        $router->post('rotations', ['uses' => 'API\RotationController@create']);
        $router->delete('rotations/{id}', ['uses' => 'API\RotationController@delete']);
    });
});
