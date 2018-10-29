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
