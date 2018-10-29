[В начало](../index.md)
---

# Фронт сайта

## Установка

Установка пакетов

```
npm install
```

Сборка пакетов для разработки
```
npm run dev
```

Сборка пакетов для разработки с перезагрузкой

Для правильной работы browserSync надо указать хост проекта в webpack.mix.js
в этой стороке
```js
.browserSync('хост.test');
```
```
npm run watch
```

Сборка пакетов на продакшн
```
npm run prod
```

## Структура файлов

* resources/assets/js/main/app.js - Входной файл
* resources/assets/js/main/bootstrap.js - Подключение плагинов
* resources/assets/js/main/index.js - Регистрация компонентов
* resources/assets/js/main/store.js - Центральное хранилище
* resources/assets/js/main/router/index.js - Маршрутизация

## Документация стеков

Vuejs - https://vuejs.org/

Vuex - https://vuex.vuejs.org/

Vue-router https://router.vuejs.org/

Axios - https://github.com/axios/axios

## Обязательные требования

Для серверного рендеринга нужен php класс v8js ниже туториал установки расширение

https://github.com/phpv8/v8js/blob/php7/README.Linux.md

## API

#### Шаблон ответа к запросам


Успех

```
{
    "success": true,
    "data": {
        "some" : "data"
    }
}
```

Ошибка

```
{
    "success": false,
    "data": {
        "message": "NOT FOUND",
        "code": 404
    }
}
```