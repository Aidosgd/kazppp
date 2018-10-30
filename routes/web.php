<?php

/*
|--------------------------------------------------------------------------
| Админка
|--------------------------------------------------------------------------
| Роуты связанные с админкой
|
*/

Route::get('admin/auth/login', 'Backend\AuthController@getLogin')->name('admin.get.login');
Route::post('admin/auth/login', 'Backend\AuthController@postLogin')->name('admin.post.login');
Route::get('admin/auth/logout', 'Backend\AuthController@logout')->name('admin.logout');


Route::group(['prefix' => 'admin', 'middleware' => 'adminMiddleware:admins'], function () {
    Route::get('/', 'Backend\HomeController@index')->name('admin.home');

    Route::group(['prefix' => 'users/admins/profile'], function () {
        Route::get('/', 'Backend\Users\Admins\AdminProfileController@profile')->name('admin.users.admins.profile');
        Route::post('update', 'Backend\Users\Admins\AdminProfileController@update')->name('admin.users.admins.profile.update');
    });

    Route::group(['prefix' => 'users/admins', 'middleware' => 'adminPermissionMiddleware:manage_admins'], function () {

        Route::get('/', 'Backend\Users\Admins\AdminController@index')->name('admin.users.admins');
        Route::get('get-list', 'Backend\Users\Admins\AdminController@getList')->name('admin.users.admins.list');
        Route::get('create', 'Backend\Users\Admins\AdminController@create')->name('admin.users.admins.create');
        Route::post('store', 'Backend\Users\Admins\AdminController@store')->name('admin.users.admins.store');
        Route::get('{userId}/edit', 'Backend\Users\Admins\AdminController@edit')->name('admin.users.admins.edit');
        Route::post('{userId}/update', 'Backend\Users\Admins\AdminController@update')->name('admin.users.admins.update');

        Route::group(['prefix' => 'roles'], function () {

            Route::get('/', 'Backend\Users\Admins\RoleController@index')->name('admin.users.admins.roles');
            Route::get('get-list', 'Backend\Users\Admins\RoleController@getList')->name('admin.users.admins.roles.list');
            Route::get('create', 'Backend\Users\Admins\RoleController@create')->name('admin.users.admins.roles.create');
            Route::post('store', 'Backend\Users\Admins\RoleController@store')->name('admin.users.admins.roles.store');
            Route::get('{roleId}/edit', 'Backend\Users\Admins\RoleController@edit')->name('admin.users.admins.roles.edit');
            Route::post('{roleId}/update', 'Backend\Users\Admins\RoleController@update')->name('admin.users.admins.roles.update');
        });
    });

    Route::group(['prefix' => 'categories'], function () {

        Route::get('list', 'Backend\CategoriesController@getCategoryList')->name('admin.categories.list');
        Route::get('create', 'Backend\CategoriesController@create')->name('admin.categories.create');
        Route::post('store', 'Backend\CategoriesController@store')->name('admin.categories.store');
        Route::get('{categoryId}/edit', 'Backend\CategoriesController@edit')->name('admin.categories.edit');
        Route::post('{categoryId}/update', 'Backend\CategoriesController@update')->name('admin.categories.update');
        Route::get('{categoryId}/destroy', 'Backend\CategoriesController@destroy')->name('admin.categories.destroy');
        Route::get('{categoryId}/up', 'Backend\CategoriesController@up')->name('admin.categories.up');
        Route::get('{categoryId}/down', 'Backend\CategoriesController@down')->name('admin.categories.down');
    });

    Route::group(['prefix' => 'news', 'middleware' => 'adminPermissionMiddleware:content_news'], function () {
        Route::get('/', 'Backend\Content\NewsController@index')->name('admin.content.news');
        Route::get('get-list', 'Backend\Content\NewsController@getList')->name('admin.content.news.list');
        Route::get('create', 'Backend\Content\NewsController@create')->name('admin.content.news.create');
        Route::post('store', 'Backend\Content\NewsController@store')->name('admin.content.news.store');
        Route::get('{itemId}/edit', 'Backend\Content\NewsController@edit')->name('admin.content.news.edit');
        Route::post('{itemId}/update', 'Backend\Content\NewsController@update')->name('admin.content.news.update');
        Route::get('{itemId}/destroy', 'Backend\Content\NewsController@destroy')->name('admin.content.news.destroy');
        Route::post('{itemId}/media', 'Backend\Content\NewsController@media')->name('admin.content.news.media');
        Route::get('{mediaId}/delete-media', 'Backend\Content\NewsController@deleteMedia')->name('admin.content.news.delete.media');
        Route::get('{itemId}/{mediaId}/main-media', 'Backend\Content\NewsController@mainMedia')->name('admin.content.news.main.media');
        Route::get('{mediaId}/crop', 'Backend\Content\NewsController@imageCrop')->name('admin.content.news.image.crop');
        Route::post('{mediaId}/crop-store', 'Backend\Content\NewsController@imageCropStore')->name('admin.content.news.image.crop.store');
    });

    Route::group(['prefix' => 'pages', 'middleware' => 'adminPermissionMiddleware:content_pages'], function() {
        Route::get('/', 'Backend\Content\PageController@index')->name('admin.content.pages');
        Route::get('get-list', 'Backend\Content\PageController@getList')->name('admin.content.pages.list');
        Route::get('create', 'Backend\Content\PageController@create')->name('admin.content.pages.create');
        Route::post('store', 'Backend\Content\PageController@store')->name('admin.content.pages.store');
        Route::get('{pageId}/edit', 'Backend\Content\PageController@edit')->name('admin.content.pages.edit');
        Route::post('{pageId}/update', 'Backend\Content\PageController@update')->name('admin.content.pages.update');
        Route::get( '{pageId}/destroy', 'Backend\Content\PageController@destroy' )->name( 'admin.content.pages.destroy' );
        Route::post('{pageId}/media', 'Backend\Content\PageController@media')->name('admin.content.pages.media');
        Route::get('{pageId}/{mediaId}/main-media', 'Backend\Content\PageController@mainMedia')->name('admin.content.pages.main.media');
        Route::get('{mediaId}/delete-media', 'Backend\Content\PageController@deleteMedia')->name('admin.content.pages.delete.media');

        Route::post('{mediaId}/update-media', 'Backend\Content\PageController@updateMedia')->name('admin.content.pages.update.media');

        Route::get('{mediaId}/crop', 'Backend\Content\PageController@imageCrop')->name('admin.content.pages.image.crop');
        Route::post('{mediaId}/crop-store', 'Backend\Content\PageController@imageCropStore')->name('admin.content.pages.image.crop.store');


    });

    Route::group(['prefix' => 'settings'], function () {

        Route::group(['prefix' => 'menu', 'middleware' => 'adminPermissionMiddleware:settings_menu'], function () {
            Route::get('/', 'Backend\Settings\MenuController@index')->name('admin.settings.menu');
            Route::get('get-list', 'Backend\Settings\MenuController@getList')->name('admin.settings.menu.list');
            Route::get('create', 'Backend\Settings\MenuController@create')->name('admin.settings.menu.create');
            Route::post('store', 'Backend\Settings\MenuController@store')->name('admin.settings.menu.store');
            Route::get('{menuId}/edit', 'Backend\Settings\MenuController@edit')->name('admin.settings.menu.edit');
            Route::post('{menuId}/update', 'Backend\Settings\MenuController@update')->name('admin.settings.menu.update');

            Route::get('{menuId}/view', 'Backend\Settings\MenuController@view')->name('admin.settings.menu.item.view');
            Route::get('{menuId}/submenu/create', 'Backend\Settings\MenuController@itemCreate')->name('admin.settings.menu.item.create');
            Route::post('{menuId}/submenu/store', 'Backend\Settings\MenuController@itemStore')->name('admin.settings.menu.item.store');
            Route::get('{menuId}/submenu/{submenuId}/edit', 'Backend\Settings\MenuController@itemEdit')->name('admin.settings.menu.item.edit');
            Route::post('{menuId}/submenu/{submenuId}/update', 'Backend\Settings\MenuController@itemUpdate')->name('admin.settings.menu.item.update');
            Route::get('{menuId}/submenu/{submenuId}/up', 'Backend\Settings\MenuController@up')->name('admin.settings.menu.up');
            Route::get('{menuId}/submenu/{submenuId}/down', 'Backend\Settings\MenuController@down')->name('admin.settings.menu.down');
            Route::get('{menuId}/submenu/{submenuId}/destroy', 'Backend\Settings\MenuController@itemDestroy')->name('admin.settings.menu.destroy');

            Route::group(['prefix' => 'manage'], function () {
                Route::get('/', 'Backend\SettingController@menu')->name('admin.menu.manage');
                Route::post('update', 'Backend\SettingController@menuUpdate')->name('admin.menu.manage.update');
                Route::get('footer','Backend\SettingController@footer')->name('admin.footer.manage');
                Route::post('footer-update','Backend\SettingController@footerUpdate')->name('admin.footer.manage.update');
            });
        });

        Route::group(['prefix' => 'seo', 'middleware' => 'adminPermissionMiddleware:settings_seo'], function () {
            Route::get('handle', 'Backend\Settings\SeoController@handle')->name('admin.settings.seo.handle');
            Route::post('update', 'Backend\Settings\SeoController@update')->name('admin.settings.seo.update');
        });

        Route::group(['prefix' => 'media'], function () {
            Route::get('model/{owner}/{modelId}', 'Backend\Settings\MediaController@getModelMedia')->name('admin.media.model');
            Route::post('model/{owner}/{modelId}/upload', 'Backend\Settings\MediaController@addMediaForModel')->name('admin.media.model.upload');
            Route::get('{mediaId}/delete', 'Backend\Settings\MediaController@deleteMediaForModel')->name('admin.media.model.delete');
            Route::get('{mediaId}/set-main', 'Backend\Settings\MediaController@setMediaMain')->name('admin.media.model.main');

        });

        Route::group(['prefix' => 'wysiwyg'], function () {
            Route::get('objects', 'Backend\Core\WysiwygController@objects')->name('admin.wysiwyg.objects');
            Route::get('objects/{id}/inject', 'Backend\Core\WysiwygController@inject')->name('admin.wysiwyg.objects.inject');
            Route::get('folder/create', 'Backend\Core\WysiwygController@folderCreate')->name('admin.wysiwyg.folder.create');
            Route::post('folder/store', 'Backend\Core\WysiwygController@folderStore')->name('admin.wysiwyg.folder.store');
            Route::get('folder/{id}/edit', 'Backend\Core\WysiwygController@folderEdit')->name('admin.wysiwyg.folder.edit');
            Route::post('folder/{id}/update', 'Backend\Core\WysiwygController@folderUpdate')->name('admin.wysiwyg.folder.update');
            Route::get('folder/{id}/delete', 'Backend\Core\WysiwygController@folderDelete')->name('admin.wysiwyg.folder.delete');
            Route::post('file/store', 'Backend\Core\WysiwygController@fileStore')->name('admin.wysiwyg.file.store');
            Route::get('file/{id}/delete', 'Backend\Core\WysiwygController@fileDelete')->name('admin.wysiwyg.file.delete');
            Route::get('image/{id}/edit', 'Backend\Core\WysiwygController@imageEdit')->name('admin.wysiwyg.image.edit');
            Route::post('image/{id}/update', 'Backend\Core\WysiwygController@imageUpdate')->name('admin.wysiwyg.image.update');
        });
    });

    Route::group(['prefix' => 'menu'], function () {
        Route::get('/', 'Backend\SettingController@menu')->name('admin.menu');
        Route::post('update', 'Backend\SettingController@menuUpdate')->name('admin.menu.update');
        Route::get('footer','Backend\SettingController@footer')->name('admin.footer');
        Route::post('footer-update','Backend\SettingController@footerUpdate')->name('admin.footer.update');
    });

    Route::group(['prefix' => 'examples/contacts', 'middleware' => 'adminPermissionMiddleware:examples_contact_list'], function () {

        // главная страница контакт листа
        Route::get('/', 'Backend\Examples\ContactController@index')->name('admin.examples.contacts');

        // получение списка созданных данных
        Route::get('get-list', 'Backend\Examples\ContactController@getList')->name('admin.examples.contacts.list');

        // форма создания контакта
        Route::get('create', 'Backend\Examples\ContactController@create')->name('admin.examples.contacts.create');

        // прием данных с формы и запись в бд
        Route::post('store', 'Backend\Examples\ContactController@store')->name('admin.examples.contacts.store');

        // получение данных и вывод в форму для редактирования
        Route::get('{id}/edit', 'Backend\Examples\ContactController@edit')->name('admin.examples.contacts.edit');

        // обновление данных в бд пришедших с формы
        Route::post('{id}/update', 'Backend\Examples\ContactController@update')->name('admin.examples.contacts.update');

        // удаление данных с бд
        Route::get('{id}/delete', 'Backend\Examples\ContactController@delete')->name('admin.examples.contacts.delete');
    });

});

/*
|--------------------------------------------------------------------------
| Frontend
|--------------------------------------------------------------------------
| Главный роут для фронта. (SSR V8js)
|
*/

Route::get('/',                 'Frontend\MainController@index');
Route::get('/page/{slug}',      'Frontend\MainController@page');
Route::get('/contacts',         'Frontend\MainController@contacts');
