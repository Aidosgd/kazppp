<?php

use Illuminate\Support\Facades;

/*
|--------------------------------------------------------------------------
| API для фронта(Vue or etc).
|--------------------------------------------------------------------------
| Функции возвращают ответ в формате JSON
|
| Пример успешного ответа:
|
| {
|    "success": true,
|    "data": {}
| }
|
*/

/*
|--------------------------------------------------------------------------
| Главная страница (StarterKit example home page)
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'home'], function($router)
{
    // Все контакты
    $router->get('/allContacts',       'BackendAPI\Examples\HomeController@allContacts');
    // Два контакта
    $router->get('/twoContacts',       'BackendAPI\Examples\HomeController@twoContacts');
});

/*
|--------------------------------------------------------------------------
| Отдаем JSON 404 если в API нет такого роута.
|--------------------------------------------------------------------------
*/

Route::get('/{api_route_not_found?}', function () {
    return JSON::error404();
})->name('api')->where('api_route_not_found', '.*');