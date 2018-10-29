[В начало](../index.md)
---

## Описание

Сущности контакт листа. 

**Требования**

* CRUD записи
* Создание/редактирование в модальном окне
* Удаление записей с подтверждением
* Фильтрация данных

## Реализация

**Группа и пермишен**

Необходимо добавить группу пермишенов и сам пермишен в 
сиды. Более подробная информация о правах доступа 
описана в разделе [Администраторы и права доступа](docs/arch/admins.md)

В сиде группы пермишенов добавляем новую группу. Группу назовем "Примеры работы в StarterKit"

В итоге массив данных должен выглядеть так:

```php

// database/seeds/PermissionGroupTableSeeder.php

$groups = [
    [
        'id' => 1,
        'owner' => 'admin',
        'name' => 'Пользователи'
    ],

    [
        'id' => 2,
        'owner' => 'admin',
        'name' => 'Примеры работы в StarterKit'
    ]
];

```

Следующим шагом создаем пермишен для доступа в реализуемой сущности.


```php

// database/seeds/PermissionTableSeeder.php

$permissions = [
    [
        'id' => 1,
        'owner' => 'admin',
        'group_id' => 1,
        'alias' => 'manage_admins',
        'name' => 'Управление администраторами',
        'desc' => 'Позволяет создавать администраторов и назначать им роли'
    ],
            
    [
        'id' => 2,
        'owner' => 'admin',
        'group_id' => 2,
        'alias' => 'examples_contact_list',
        'name' => 'Управление контакт листом',
        'desc' => 'Позволяет создавать/редактировать записи контакт листа'
    ]

];

```

Запускаем выполнение сидов командой `php artisan db:seed`

**Роуты**

После того, как у нас есть пермишен для доступа в раздел, 
необходимо добавить группу роутов и ограничить доступ к ней пермишеном.

В браузере мы будем получать доступ к сущности по адресу  `/admin/examples/contacts`

```php
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
    Route::get('{id}/delete', 'Backend\Examples\ContactController@delete')->name('admin.examples.contacts.update');
});
    
```

**Модель**

После того, как у нас есть роуты, мы можем создать модель для нашей сущности.

Модель можно создать следующей командой: `php artisan make:model -m Models/Contact`

Помимо самой модели, будет создана миграция. Для реализации примера, нам будет достаточно
трех полей - Имя, телефон, адрес и фото. 



```php

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone');
            $table->string('address');
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}


```

Запускаем миграцию на выполнение командой `php artisan migrate`

После того, как создана таблица, нам необходимо настроить модель. Нужно профисать fillable поля, чтобы мы могли использовать mass assignment.

После настройки, модель должна выглядеть следующим образом:

```php

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
        'photo'
    ];
}

```

**Контроллер и вьюхи**

Для управление всем, нам потребуется контроллер с некоторыми методами. 
Для создание контроллера нужно выполнить команду 

`php artisan make:controller Backend/Examples/ContactController`

В первую очередь нам нужно подключить модель в контроллер и создать инстанс.

После этого контроллер должен выглядеть так:

```php

<?php

namespace App\Http\Controllers\Backend\Examples;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Contact;

class ContactController extends Controller
{
    private $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }
}


```

Следующим шагом, необходимо создать пока что две 
вьюхи index и form. Для этого нужно в каталоге 

`resources/views/backend/examples/contacts` 

создать два файла index.blade.php и form.blade.php

В index.blade.php добавим следующий код:

```html

@extends('backend.layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('content')

    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{ $title }}
                    </h3>
                </div>
            </div>

            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">

                    <li class="m-portlet__nav-item">
                        <a href="{{ route('admin.examples.contacts.create') }}"
                           data-type="modal" data-modal="#largeModal"
                           class="m-portlet__nav-link m-portlet__nav-link--icon handle-click"
                           data-container="body"
                           data-toggle="m-tooltip"
                           data-placement="top"
                           title="Создать контакт">
                            <i class="la la-user-plus"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>


        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content">
                <table class="table table-bordered ajax-content" id="ajaxContactTable"
                       data-ajax-content-url="{{ route('admin.examples.contacts.list') }}">
                    <thead>
                    <tr>
                        <th class="text-center" width="50">Id</th>
                        <th>Имя</th>
                        <th>Телефон</th>
                        <th>Адрес</th>
                        <th class="text-center" width="50"><i class="fa fa-bars" aria-hidden="true"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <div class="pagination_placeholder" data-table-id="ajaxContactTable"></div>
            </div>
        </div>
        <!--end::Section-->
    </div>
@endsection

```

Далее, подключим вызов этой вьюхи в контроллере в методе index

После этого контроллер должен выглядеть так:

```php

<?php

namespace App\Http\Controllers\Backend\Examples;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Contact;

class ContactController extends Controller
{
    private $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }
    
    public function index()
    {
        return view('backend.examples.contacts.index', [
            'title' => 'Контакт лист'
        ]);
    }
}


```

Мы передали во вьюху переменную `title` которая будет отображена в теге `H3` с классом `m-portlet__head-text`

Далее о важных параметрах у ссылки добавления записи. 
Нам требуется, чтобы форма создания записи была открыта в модальном окне. 
Для этого ссылку нужно оформить следующим образом

```html

<li class="m-portlet__nav-item">
    <a href="{{ route('admin.examples.contacts.create') }}"
    data-type="modal" data-modal="#largeModal"
    class="m-portlet__nav-link m-portlet__nav-link--icon handle-click"
    data-container="body"
    data-toggle="m-tooltip"
    data-placement="top"
    title="Создать контакт">
    <i class="la la-user-plus"></i>
    </a>
</li>

```
* href - определяет урл с которого будет получен контент для модалки
* data-type="modal" - определяет тип ссылки. В данном случае ссылка является контроллом для раскрытия модалки
* data-modal="#largeModal" тут мы определяем  ID модалки которую нужно открыть. Есть три вида  модальных окна (regularModal - это маленькое модальное окно, largeModal - это окно средней величины, superLargeModal - это окно на весь экран)
* class="handle-click" этим классом мы задаем то, что ссылка будет обработана и с нее будут считаны параметры заданые нами

Если требуется отследить клик по ссылке и что-то сделать, то нам всегда нужно задать класс `handle-click` и обозначить дополнительные атрибуты. Более подробно об этом написано на странице о [core.js](../arch/core_js.md)

Следущим шагом, нам требуется в контроллере в методе create отдать форму создания записи.


```php

<?php

namespace App\Http\Controllers\Backend\Examples;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Contact;

class ContactController extends Controller
{
    private $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function index()
    {
        return view('backend.examples.contacts.index', [
            'title' => 'Контакт лист'
        ]);
    }
    
    public function create()
    {
        return response()->json([
            'type' => 'updateModal',
            'modal' => '#largeModal',
            'modalTitle' => 'Создание контакта',
            'modalContent' => view('backend.examples.contacts.form', [
                'formAction' => route('admin.examples.contacts.store'),
                'buttonText' => 'Создать'
            ])->render()
        ]);
    }
}


```

**Описание массива переданного в response**

* type - тип ответа. В данном случае `updateModal` означает, что нам нужно обновить модалку которая была открыта по handle-click и всунуть в нее контент
* modal - определяет модальное окно в которое будет добавлен контент
* modalTitle - заголовок модального окна
* modalContent - сюда передается отрендеренная вьюха

**Вьюха form.blade.php**

```html
<form action="{{ $formAction }}"
      method="post" class="ajax"
      data-ui-block-type="element"
      data-ui-block-element="#largeModal .modal-body"
      id="ajaxForm">


        <div class="form-group">
            <label for="name">Имя контакта *</label>
            <input type="text"
                   autocomplete="off"
                   class="form-control m-input m-input--square"
                   id="name" name="name">
            <p class="help-block"></p>
        </div>

        <div class="form-group">
            <label for="phone">Телефон контакта *</label>
            <input type="text"
                   autocomplete="off"
                   class="form-control m-input m-input--square"
                   id="phone" name="phone">
            <p class="help-block"></p>
        </div>

        <div class="form-group">
            <label for="address">Адрес контакта *</label>
            <input type="text"
                   autocomplete="off"
                   class="form-control m-input m-input--square"
                   id="address" name="address">
            <p class="help-block"></p>
        </div>

        <div class="form-group">
            <label for="address">Фото контакта</label>
            <input type="file"
                   autocomplete="off"
                   class="form-control m-input m-input--square"
                   id="photo" name="photo">
            <p class="help-block"></p>
        </div>
    
    <button type="submit" class="btn btn-brand btn-sm">{{  $buttonText }} </button>
    <button type="button" class="btn btn-outline-accent btn-sm float-right" data-dismiss="modal">Отмена</button>

</form>
```

**Пояснения по форме**

* class="ajax" - означает, что форма будет отправлена на сервер без перезагрузки страницы (core.js)
* data-ui-block-type="element" - тип блокировки интерфейса. В данном случае будет заблокирована часть интерфеса определенная в следующем атрибуте
* data-ui-block-element="#largeModal .modal-body" - тут мы определяем зону блокировки интерфейса

**Требования к форме**

* ID - у формы обязательно должен быть задан любой ID
* Все инпуты должны быть обернуты в `<div class="form-group">`
* У каждого инпута должен быть ID идентичный его имени

**Вьюха item.blade.php**

Данная вьюха реализует отображение одной строки в таблице. Выглядит следующим образом:

```html

<tr class="row-{{$item->id}}">
    <td class="text-center">{{$item->id}}</td>
    <td>{{$item->name}}</td>
    <td>{{$item->phone}}</td>
    <td>{{$item->address}}</td>
    <td class="text-center">
        <a href="{{ route('admin.examples.contacts.edit', ['id' => $item->id ]) }}" class="handle-click" data-type="modal" data-modal="#largeModal">
            <i class="la la-edit"></i>
        </a>
        
        <a class="handle-click" data-type="delete-table-row"
            data-confirm-title="Удаление"
            data-confirm-message="Вы уверены, что хотите удалить контакт"
            data-cancel-text="Нет"
            data-confirm-text="Да, удалить" href="{{ route('admin.examples.contacts.delete', ['id' => $item->id ]) }}">
            <i class="la la-trash"></i>
       
        </a>
    </td>
</tr>



```

**Пояснения по вьюхе**

* класс у tr. Он обязателен и называется как `row-{id_записи}` Это нужно для core.js чтобы понимать какую строку 
обновить в случае редактирования
* Ссылка на редактирование контакта реализована точно так же, как и ссылка на создание контакта.
* По клику на ссылку удаления контакта будет показан конфирм и при подтверждении 
действия будет отправлен запрос на бэкэнд для удаления

Далее в контроллере в методе store мы выполним следующее:

* Через FormRequest проверим заполненна ли форма
* Создадим запись в бд
* Дадим response в котором передадим html строки таблицы и команду на закрытие модалки




**Form request**

Для валидации формы нам нужен request. Создадим его следующей командой:

`php artisan make:request Backend/ContactRequest`

И заполним его следующим образом:

```php

<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\MessagesTrait;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;
class ContactRequest extends FormRequest
{
    use MessagesTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // определяем может ли пользователь отправлять запрос
        return Auth::guard('admins')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'photo' => 'image'
        ];
    }
}


```

**Сохранение данных в БД**

Вот таким образом выглядит контроллер с методом store:

```php

<?php

namespace App\Http\Controllers\Backend\Examples;

use App\Http\Controllers\Controller;

// models
use App\Models\Contact;

// requests
use App\Http\Requests\Backend\ContactRequest;



class ContactController extends Controller
{
    private $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function index()
    {
        return view('backend.examples.contacts.index', [
            'title' => 'Контакт лист'
        ]);
    }

    public function create()
    {
        return response()->json([
            'type' => 'updateModal',
            'modal' => '#largeModal',
            'modalTitle' => 'Создание контакта',
            'modalContent' => view('backend.examples.contacts.form', [
                'formAction' => route('admin.examples.contacts.store'),
                'buttonText' => 'Создать'
            ])->render()
        ]);
    }

    public function store(ContactRequest $request)
    {
        $item = $this->contact->create($request->all());

        if ($request->hasFile('photo'))
        {
            // положим изображение в каталог storage/app/public/media
            $fileName = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();

            $request->file('photo')->storeAs(
                'public/media', $fileName
            );
        }

        return response()->json([
            'functions' => ['closeModal'],
            'modal' => '#largeModal',
            'type' => 'prepend-table-row',
            'table' => '#ajaxContactTable',
            'content' => view('backend.examples.contacts.item', ['item' => $item])->render()
        ]);
    }
}


```

**Пояснение по response**

* functions - массив запускаемых функций core.js 
В данном случе нам нужно закрыть модалку после того, как создана запись.
* modal - в этом параметре передается айди модалки, которую требуется закрыть
* type - response type. В данному случае мы говорим, что хотим добавить в начало таблицы некоторые данные
* table - тут мы передаем айди таблицы в которую будут добавлены данные
* content - собственно сам контент, строка таблицы (отрендеренная вьюха)


**Редактирование данных в БД**

Далее рассмотрим редактирование. В item.blade.php мы 
добавили колонку в которой указали ссылку на 
редактирование. В атрибуте href мы указали роут на 
редактирование. Ссылка имеет класс `handle-click` 
который будет обработан core.js

Вот так будет выглядеть контроллер с методом edit:

```php

<?php

namespace App\Http\Controllers\Backend\Examples;

use App\Http\Controllers\Controller;

// models
use App\Models\Contact;

// requests
use App\Http\Requests\Backend\ContactRequest;



class ContactController extends Controller
{
    private $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function index()
    {
        return view('backend.examples.contacts.index', [
            'title' => 'Контакт лист'
        ]);
    }

    public function create()
    {
        return response()->json([
            'type' => 'updateModal',
            'modal' => '#largeModal',
            'modalTitle' => 'Создание контакта',
            'modalContent' => view('backend.examples.contacts.form', [
                'formAction' => route('admin.examples.contacts.store'),
                'buttonText' => 'Создать'
            ])->render()
        ]);
    }

    public function store(ContactRequest $request)
    {
        $item = $this->contact->create($request->all());

        if ($request->hasFile('photo'))
        {
            // положим изображение в каталог storage/app/public/media
            $fileName = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();

            $request->file('photo')->storeAs(
                'public/media', $fileName
            );
        }

        return response()->json([
            'functions' => ['closeModal'],
            'modal' => '#largeModal',
            'type' => 'prepend-table-row',
            'table' => '#ajaxContactTable',
            'content' => view('backend.examples.contacts.item', ['item' => $item])->render()
        ]);
    }

    public function edit($id)
    {
        $item = $this->contact->find($id);

        return response()->json([
            'type' => 'updateModal',
            'modal' => '#largeModal',
            'modalTitle' => 'Редактирование контакта',
            'modalContent' => view('backend.examples.contacts.form', [
                'item' => $item,
                'formAction' => route('admin.examples.contacts.update', ['id' => $item->id]),
                'buttonText' => 'Сохранить',
            ])->render()
        ]);
    }
}


```

**Загрузка данных в таблицу**

Далее, нам необходимо сделать, чтобы при загрузке 
страницы загружались данные в таблицу. Ранее мы уже настроили 
таблицу и при загрузке идет запрос на бэкэнд в метод getList. 
Контроллер с этим методом выглядит следующим образом:

```php

<?php

namespace App\Http\Controllers\Backend\Examples;

use App\Http\Controllers\Controller;

// models
use App\Models\Contact;

// requests
use App\Http\Requests\Backend\ContactRequest;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    private $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function index()
    {
        return view('backend.examples.contacts.index', [
            'title' => 'Контакт лист'
        ]);
    }

    public function getList(Request $request)
    {
        $query = $this->contact->orderBy('created_at', 'desc');

        if ($request->has('filter'))
        {

        }

        $items = $query->paginate(50);

        return response()->json([
            'tableData' => view('backend.examples.contacts.list', [
                'items' => $items,
                'filters' => $request->all()
            ])->render(),
            'pagination' => view('backend.common.pagination', [
                'links' => $items->links('vendor.pagination.bootstrap-4'),
            ])->render(),
        ]);

    }

    public function create()
    {
        return response()->json([
            'type' => 'updateModal',
            'modal' => '#largeModal',
            'modalTitle' => 'Создание контакта',
            'modalContent' => view('backend.examples.contacts.form', [
                'formAction' => route('admin.examples.contacts.store'),
                'buttonText' => 'Создать'
            ])->render()
        ]);
    }

    public function store(ContactRequest $request)
    {
        $item = $this->contact->create($request->all());

        if ($request->hasFile('photo'))
        {
            // положим изображение в каталог storage/app/public/media
            $fileName = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();

            $request->file('photo')->storeAs(
                'public/media', $fileName
            );
        }

        return response()->json([
            'functions' => ['closeModal'],
            'modal' => '#largeModal',
            'type' => 'prepend-table-row',
            'table' => '#ajaxContactTable',
            'content' => view('backend.examples.contacts.item', ['item' => $item])->render()
        ]);
    }

    public function edit($id)
    {
        $item = $this->contact->find($id);

        return response()->json([
            'type' => 'updateModal',
            'modal' => '#largeModal',
            'modalTitle' => 'Редактирование контакта',
            'modalContent' => view('backend.examples.contacts.form', [
                'item' => $item,
                'formAction' => route('admin.examples.contacts.update', ['id' => $item->id]),
                'buttonText' => 'Сохранить',
            ])->render()
        ]);
    }
}


```

Далле оформим вьюху list.blade.php. Она выглядит очень просто))

```blade
@foreach($items as $item)
    @include('backend.examples.contacts.item')
@endforeach
```


Пока в методе стоит пустой `if ($request->has('filter'))`, но позже мы это исправим. 
Этот метод возвращает response со следующими параметрами:

* tableData - отрендеренная вьюха со списком
* pagination - отрендеренная вьюха пагинации

**Обновление и удаление данных**

Далее необходимо сделать метод для обновления данных и удаления. 
Контроллер с методом update и  будет выглядеть следующим образом

```php

<?php

namespace App\Http\Controllers\Backend\Examples;

use App\Http\Controllers\Controller;

// models
use App\Models\Contact;

// requests
use App\Http\Requests\Backend\ContactRequest;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    private $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function index()
    {
        return view('backend.examples.contacts.index', [
            'title' => 'Контакт лист'
        ]);
    }

    public function getList(Request $request)
    {
        $query = $this->contact->orderBy('created_at', 'desc');

        if ($request->has('filter'))
        {

        }

        $items = $query->paginate(50);

        return response()->json([
            'tableData' => view('backend.examples.contacts.list', [
                'items' => $items,
                'filters' => $request->all()
            ])->render(),
            'pagination' => view('backend.common.pagination', [
                'links' => $items->links('vendor.pagination.bootstrap-4'),
            ])->render(),
        ]);

    }

    public function create()
    {
        return response()->json([
            'type' => 'updateModal',
            'modal' => '#largeModal',
            'modalTitle' => 'Создание контакта',
            'modalContent' => view('backend.examples.contacts.form', [
                'formAction' => route('admin.examples.contacts.store'),
                'buttonText' => 'Создать'
            ])->render()
        ]);
    }

    public function store(ContactRequest $request)
    {
        $item = $this->contact->create($request->all());

        if ($request->hasFile('photo'))
        {
            // положим изображение в каталог storage/app/public/media
            $fileName = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();

            $request->file('photo')->storeAs(
                'public/media', $fileName
            );

            $item->photo = $fileName;
            $item->save();
        }

        return response()->json([
            'functions' => ['closeModal'],
            'modal' => '#largeModal',
            'type' => 'prepend-table-row',
            'table' => '#ajaxContactTable',
            'content' => view('backend.examples.contacts.item', ['item' => $item])->render()
        ]);
    }

    public function edit($id)
    {
        $item = $this->contact->find($id);

        return response()->json([
            'type' => 'updateModal',
            'modal' => '#largeModal',
            'modalTitle' => 'Редактирование контакта',
            'modalContent' => view('backend.examples.contacts.form', [
                'item' => $item,
                'formAction' => route('admin.examples.contacts.update', ['id' => $item->id]),
                'buttonText' => 'Сохранить',
            ])->render()
        ]);
    }

    public function update(ContactRequest $request, $id)
    {
        $item = $this->contact->find($id);

        $item->update($request->all());

        if ($request->hasFile('photo'))
        {
            // положим изображение в каталог storage/app/public/media
            $fileName = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();

            $request->file('photo')->storeAs(
                'public/media', $fileName
            );

            if ($item->photo)
            {
                $path = storage_path('app/public/media/' . $item->photo);

                if (file_exists($path))
                {
                    @unlink($path);
                }
            }

            $item->photo = $fileName;
            $item->save();
        }

        return response()->json([
            'functions' => ['closeModal'],
            'modal' => '#largeModal',
            'type' => 'update-table-row',
            'table' => '#ajaxContactTable',
            'row' => '.row-' . $item->id,
            'content' => view('backend.examples.contacts.item', ['item' => $item])->render()
        ]);
    }

    public function delete($id)
    {
        $this->contact->find($id)->delete();

        return response()->json([
            'type' => 'delete-table-row',
            'table' => '#ajaxContactTable',
            'row' => '.row-' . $id,
        ]);
    }
}

```

**Фильтрация данных**

Добавим форму фильтрации во вьюхе index

```html
@extends('backend.layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('content')

    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{ $title }}
                    </h3>
                </div>
            </div>

            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">

                    <li class="m-portlet__nav-item">
                        <a href="{{ route('admin.examples.contacts.create') }}"
                           data-type="modal" data-modal="#largeModal"
                           class="m-portlet__nav-link m-portlet__nav-link--icon handle-click"
                           data-container="body"
                           data-toggle="m-tooltip"
                           data-placement="top"
                           title="Создать контакт">
                            <i class="la la-user-plus"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>


        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content">
                <div class="m-portlet__body">
                    <form action="{{route('admin.examples.contacts.list')}}" method="get" data-table="#ajaxContactTable" class="filter-form">

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="filter.name">Имя </label>
                                    <input type="text" class="form-control" id="filter.name" name="filter[name]" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="filter.phone">Телефон </label>
                                    <input type="text" class="form-control" id="filter.phone" name="filter[phone]" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="filter.address">Адрес </label>
                                    <input type="text" class="form-control" id="filter.address" name="filter[address]" autocomplete="off">
                                </div>
                            </div>

                        </div>


                        <div >
                            <button type="submit" class="btn btn-sm btn-success">Фильтр</button>
                            <a href="{{route('admin.examples.contacts')}}" class="btn btn-sm btn-info">Сбросить</a>
                        </div>
                    </form>
                </div>
                <table class="table table-bordered ajax-content" id="ajaxContactTable"
                       data-ajax-content-url="{{ route('admin.examples.contacts.list') }}">
                    <thead>
                    <tr>
                        <th class="text-center" width="50">Id</th>
                        <th>Имя</th>
                        <th>Телефон</th>
                        <th>Адрес</th>
                        <th class="text-center" width="50"><i class="fa fa-bars" aria-hidden="true"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <div class="pagination_placeholder" data-table-id="ajaxContactTable"></div>
            </div>
        </div>
        <!--end::Section-->
    </div>
@endsection

```

**Пояснение по форме фильтрации**

* Атрибут action - указываем роут получения списка
* Атрибут class - Указываем значение filter-form
* Атрибут data-table - указываем ID таблицы для которой будет работать фильтр

**Итоговый вид контроллера**

```php

<?php

namespace App\Http\Controllers\Backend\Examples;

use App\Http\Controllers\Controller;

// models
use App\Models\Contact;

// requests
use App\Http\Requests\Backend\ContactRequest;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    private $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function index()
    {
        return view('backend.examples.contacts.index', [
            'title' => 'Контакт лист'
        ]);
    }

    public function getList(Request $request)
    {
        $query = $this->contact->orderBy('created_at', 'desc');

        if ($request->has('filter'))
        {
            foreach ($request->input('filter') as $field => $value)
            {
                switch ($field)
                {
                    case 'name':
                    case 'phone':
                    case 'address':
                        $query->where($field, 'like', "%$value%");
                        break;
                }
            }
        }

        $items = $query->paginate(50);

        return response()->json([
            'tableData' => view('backend.examples.contacts.list', [
                'items' => $items,
                'filters' => $request->all()
            ])->render(),
            'pagination' => view('backend.common.pagination', [
                'links' => $items->links('vendor.pagination.bootstrap-4'),
            ])->render(),
        ]);

    }

    public function create()
    {
        return response()->json([
            'type' => 'updateModal',
            'modal' => '#largeModal',
            'modalTitle' => 'Создание контакта',
            'modalContent' => view('backend.examples.contacts.form', [
                'formAction' => route('admin.examples.contacts.store'),
                'buttonText' => 'Создать'
            ])->render()
        ]);
    }

    public function store(ContactRequest $request)
    {
        $item = $this->contact->create($request->all());

        if ($request->hasFile('photo'))
        {
            // положим изображение в каталог storage/app/public/media
            $fileName = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();

            $request->file('photo')->storeAs(
                'public/media', $fileName
            );

            $item->photo = $fileName;
            $item->save();
        }

        return response()->json([
            'functions' => ['closeModal'],
            'modal' => '#largeModal',
            'type' => 'prepend-table-row',
            'table' => '#ajaxContactTable',
            'content' => view('backend.examples.contacts.item', ['item' => $item])->render()
        ]);
    }

    public function edit($id)
    {
        $item = $this->contact->find($id);

        return response()->json([
            'type' => 'updateModal',
            'modal' => '#largeModal',
            'modalTitle' => 'Редактирование контакта',
            'modalContent' => view('backend.examples.contacts.form', [
                'item' => $item,
                'formAction' => route('admin.examples.contacts.update', ['id' => $item->id]),
                'buttonText' => 'Сохранить',
            ])->render()
        ]);
    }

    public function update(ContactRequest $request, $id)
    {
        $item = $this->contact->find($id);

        $item->update($request->all());

        if ($request->hasFile('photo'))
        {
            // положим изображение в каталог storage/app/public/media
            $fileName = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();

            $request->file('photo')->storeAs(
                'public/media', $fileName
            );

            if ($item->photo)
            {
                $path = storage_path('app/public/media/' . $item->photo);

                if (file_exists($path))
                {
                    @unlink($path);
                }
            }

            $item->photo = $fileName;
            $item->save();
        }

        return response()->json([
            'functions' => ['closeModal'],
            'modal' => '#largeModal',
            'type' => 'update-table-row',
            'table' => '#ajaxContactTable',
            'row' => '.row-' . $item->id,
            'content' => view('backend.examples.contacts.item', ['item' => $item])->render()
        ]);
    }

    public function delete($id)
    {
        $this->contact->find($id)->delete();

        return response()->json([
            'type' => 'delete-table-row',
            'table' => '#ajaxContactTable',
            'row' => '.row-' . $id,
        ]);
    }
}


```