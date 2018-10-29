[В начало](../index.md)
---

# Новости

## Описание

Модуль новостей.

## Структура

### Таблицы

* App/Models/News

### Миграции

* 2018_03_27_122134_create_news_table.php
* 2018_03_28_111334_add_slug_to_news_table.php
* 2018_06_05_081108_add_seo_fields_to_news_table.php
* 2018_06_05_092528_change_slug_to_news_table.php

### Контроллеры

* Backend/Content/NewsController

### Form requests

* Backend/NewsRequest
* Backend/NewsCategoryRequest

### Вьюхи

* backend/content/news/index.blade.php - главная страница новостей
* backend/content/news/list.blade.php - Список для таблицы
* backend/content/news/news_item.blade.php - Строка таблицы
* backend/content/news/form.blade.php -  Форма для создания, редактирования новости.
* backend/content/news/media_list.blade.php -  Список медиафайлов новости.
* backend/content/news/media_item.blade.php -  Одна строка медиа.


