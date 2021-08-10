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
    // echo "asd";
});
// https://www.youtube.com/watch?v=g_22EUfibJ8
// https://github.com/flipboxstudio/lumen-generator
// https://www.devcoons.com/getting-started-with-lumen-7-0-x-and-jwt-authentication/
// https://jwt-auth.readthedocs.io/en/develop/quick-start/#update-your-user-model

composer require chuckrincon/lumen-config-discover
composer require tymon/jwt-auth:dev-develop

$router->group(['middleware' => 'auth','prefix' => 'api'], function ($router) 
{
    $router->get('showlogin', 'AuthController@showlogin');
    $router->get('user/{id}', 'AuthController@showone');
    $router->put('user/{id}', 'AuthController@update');
    $router->delete('user/{id}', 'AuthController@delete');
});

$router->group(['prefix' => 'api'], function () use ($router) 
{
   $router->post('register', 'AuthController@register');
   $router->post('login', 'AuthController@login');
});
