<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->get('users', 'UsersController@index');
    $router->get('dynamics', 'DynamicsController@index');
    $router->get('dynamics/create', 'DynamicsController@form');
    $router->post('dynamics', 'DynamicsController@store');
    $router->get('dynamics/{id}/edit', 'DynamicsController@edit');
    $router->put('dynamics/{id}', 'DynamicsController@update');
    $router->get('dynamics/{id}', 'DynamicsController@show');

    $router->get('comments', 'CommentsController@index');
    $router->get('comments/create', 'CommentsController@form');
    $router->post('comments', 'CommentsController@store');
    $router->get('comments/{id}/edit', 'CommentsController@edit');
    $router->put('comments/{id}', 'CommentsController@update');
    $router->get('comments/{id}', 'CommentsController@show');

    $router->get('vlogs', 'VlogsController@index');
    $router->get('vlogs/create', 'VlogsController@form');
    $router->post('vlogs', 'VlogsController@store');
    $router->get('vlogs/{id}/edit', 'VlogsController@edit');
    $router->put('vlogs/{id}', 'VlogsController@update');
    $router->get('vlogs/{id}', 'VlogsController@show');
});
