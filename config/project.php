<?php

return [
    'default_locale' => 'ru',
    'foreign_locales' => ['ru', 'en'],
    'news_images_upload_path' => storage_path() . '/app/public/news_images',
    'media_upload_path' => storage_path() . '/app/public/uploaded_images',


    'locales' => [
        [
            'locale' => 'ru',
            'desc' => 'Русский'
        ],

        [
            'locale' => 'en',
            'desc' => 'Английский'
        ],
    ],

    'menus' => [
        'top' => [
            'title' => 'Верхнее меню',
            'slug' => ''
        ],

        'footer' => [
            'title' => 'Футер',
            'slug' => ''
        ]
    ]
];