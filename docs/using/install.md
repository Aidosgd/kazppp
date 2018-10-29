[В начало](../index.md)
---

Для установки нужно сделать следующие действия:

Клонировать репозиторий в требуемую папку

```bash
git clone git@gitlab.ibecsystems.kz:turganbay/starter_56v.test.git myProject

```

Установить зависимости

```php
composer install
```

Создать симлинк на storage для отображения изображений

```php
php artisan storage:link
```

Создание .env файла

```php
cp .env.example .env
```

Прописать в `.env` данные для подключения к БД

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=starter_56
DB_USERNAME=homestead
DB_PASSWORD=secret
```

Сгенерировать ключ шифрования

```php
php artisan key:generate
```

Запустить миграции

```php
php artisan migrate
```

Создать супер администратора командой

```php
php artisan core:add-super-user
```

Авторизоваться по адресу `/admin`
