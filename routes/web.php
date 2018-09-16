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

// Get all
$router->get('/', ['uses' => 'PhotoController@getAllPhotos']);
// Add photo
$router->post('/', ['uses' => 'PhotoController@addPhoto']);
// Delete photo
$router->delete('/{filename}', ['uses' => 'PhotoController@deletePhoto']);