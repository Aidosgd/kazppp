[В начало](../index.md)
---

## Описание

Данный скрипт предназначен для облегчения работы с бэкэндом.

Скрипт реализует следующие возможности:

* Сабмит любых форм
* Обработка кликов с определенным поведением
* Загрузка данных в модалку, таблицу
* Обработка ответа от сервера


### Сабмит форм

* Отправка данных формы на сервер
* Определенное поведение в зависимости от ответа сервера

**Использование**

* ID формы - нужно указать любой уникальный айди
* Класс формы - нужно указать `ajax`
* data-ui-block-type - можно указать `element` или `page`
* В случае `data-ui-block-type="element"` нужно добавить атрибут `data-ui-block-element=""` где указать селектор блокируемого блока

**Пример**

```html
<form action="/store"
      method="post" 
      class="ajax"
      data-ui-block-type="element"
      data-ui-block-element="#largeModal .modal-body"
      id="ajaxForm">
      
</form>
```

### Обработка кликов

Мы можем отследить клик по ссылке и выполнить некоторые действия в зависимости от 
типа действия указанного в атрибуте ссылки.

Все ссылки, которые мы хотим обработать должны содержать как минимум два атрибута:

* class - handle-click
* data-type - тип

**Тип ajax-get**

При этом типе, будет отправлен get запрос на сервер, на урл указанный в атрибуте href. 
Ответ сервера будет обработан в зависимости от типа ответа.

Пример:

```html

<a href="/some" class="handle-click" data-type="ajax-get">Click</a>

```

**Тип confirm**

При клике на ссылку с этим типом будет показан 
конфирм и при подтверждении будет отправлен get запрос на сервер, ответ будет обработан в 
зависимости от типа ответа.

Требуемые атрибуты

* data-type - alert
* data-confirm-title - заголовок конфирма
* data-confirm-message - сообщение конфирма
* data-cancel-text - текст кнопки отказа подтверждения
* data-confirm-text - текст кнопки подтверждения
* data-follow-url - нужно ли отправить запрос на сервер (true/false)


Пример:

```html

<a class="handle-click" data-type="confirm"
    data-confirm-title="Удаление"
    data-confirm-message="Вы уверены, что хотите удалить"
    data-cancel-text="Нет"
    data-confirm-text="Да, удалить" 
    data-follow-url="true" 
    href="/messages/45/delete">
    Click
</a>

```

**Тип modal**

При этом типе будет открыто модальное окно и будет загружен в него контент.

Требуемые атрибуты

* data-type - modal
* data-modal - айди модалки. Существует три типа модалок (#regularModal, #largeModal, #superLargeModal)

Пример:

```html

<a  class="handle-click" 
    data-type="modal"
    data-modal="#regularModal"
    href="/messages/create">
    Show modal
</a>

```

### Обработка ответа от сервера

Не важно был ли сабмит формы или обработан клик, скрипт может обработать ответ от 
сервера в зависимости от типа ответа.

**Тип redirect**

Редирект.

Пример ответа:

```

return response()->json([
    'type' => 'redirect', // тип ответа
    'redirect_url' => '/some/url', // урл куда нужно средиректить
]);
```


**Тип prepend-table-row**

Добавление строки в таблицу. Полезно при создании записей в таблице

Пример ответа:

```

return response()->json([
    'type' => 'prepend-table-row', // тип ответа
    'table' => '#ajaxContactTable', // айди таблицы
    
    // контент строки
    'content' => view('backend.examples.contacts.item', ['item' => $item])->render()
]);

```

**Тип update-table-row**

При этом типе будет обновлена строка в указанной таблице. 
Это используется при редактировании записей.

Пример ответа:

```

return response()->json([
    'type' => 'update-table-row', // тип ответа
    'table' => '#ajaxContactTable', // таблица в которой нужно сделать действие
    'row' => '.row-' . $item->id, // строка которую нужно обновить
    'content' => view('backend.examples.contacts.item', ['item' => $item])->render() // контент которым нужно обновить
]);

```

**Тип delete-table-row**

Удаление строки в таблице

Пример ответа:

```
return response()->json([
    'type' => 'delete-table-row', // тип ответа
    'table' => '#ajaxContactTable', // таблица в которой нужно сделать действие
    'row' => '.row-' . $id, // класс строки таблицы
]);
        
```

**Тип updateModal**

Обновление контента модального окна. 

Пример ответа:

```

return response()->json([
    'type' => 'updateModal', // тип ответа
    'modal' => '#largeModal', // айди модалки в которой нужно обновить
    'modalTitle' => 'Создание контакта', // заголовок модалки
    
    // контент модалки
    'modalContent' => view('backend.examples.contacts.form', [
        'formAction' => route('admin.examples.contacts.store'),
        'buttonText' => 'Создать'
    ])->render()
]);
        
```

**Тип reloadTable**

Перезагрузка данных в таблице.

Пример ответа:

```

return response()->json([
    'type' => 'reloadTable', // тип ответа
    'tableContentUrl' => '/some/url', // урл отдающий контент таблицы
    'tableId' => '#ajaxTable', // айди таблицы которую нужно перезагрузить
]);
        
```

#### Запуск функций



Помимо отправки типизированного ответа, можно передать список функций, 
которые следует запустить. Если функция требует параметров, то их тоже нужно добавить в response.

Существует несколько встроенных функций:

**Закрытие модального окна**

Например, после создания записи мы отвечаем типом `prepend-table-row` а также передаем фукнцию которая закроет модалку

Пример ответа:

```

return response()->json([
    'functions' => ['closeModal'], // массив функций
    'modal' => '#largeModal', // параметр для функции closeModal
    'type' => 'prepend-table-row',
    'table' => '#ajaxContactTable',
    'content' => view('backend.examples.contacts.item', ['item' => $item])->render()
]);

```

**Инициализация визивига**

Например, нам нужно инициализировать визивиг при созании новости в модалке.

Важно, чтобы у `textarea` был задан класс `editor`

Пример ответа:

```

return response()->json([
    'functions' => ['initEditor'],
    'type' => 'updateModal',
    'modal' => '#superLargeModal',
    'modalTitle' => 'Создание новости',
    'modalContent' => view('backend.content.pages.form')->render()
]);

```