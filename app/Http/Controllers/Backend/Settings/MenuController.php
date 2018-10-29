<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\FormatTrait;
use App\Http\Controllers\ResponseTrait;

use App\Http\Requests\Backend\MenuRequest;
use App\Models\Category;
use App\Models\Menu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    use ResponseTrait;
    use FormatTrait;

    private $menu;
    private $category;

    public function __construct(Menu $menu, Category $category)
    {
        $this->menu = $menu;
        $this->category = $category;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $menus = $this->category->where('owner', 'master-menu')->get();

        return view('backend.settings.menu.index', [
            'title' => 'Список Меню',
            'menus' => $menus,

        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function create()
    {
        $data = [
            'modalTitle' => 'Создание меню',
            'modalContent' => view('backend.settings.menu.form', [
                'formAction' => route('admin.settings.menu.store'),
                'buttonText' => 'Создать',
            ])->render()
        ];

        return $this->responseJson($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $this->category->create([
            'name' => [
                'ru' => $request->input('name'),
            ],
            'owner' => 'master-menu',
        ]);

        $menus = $this->category->where('owner', 'master-menu')->get();

        return $this->responseJson([
            'functions' => ['updateBlock', 'closeModal'],
            'targetModal' => '#regularModal',
            'blockId' => '#menusList',
            'blockData' => view('backend.settings.menu.list', [
                'menus' => $menus
            ])->render(),
            'success' => 'Меню добавлено'
        ]);
    }

    /**
     * @param $menuId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function edit($menuId)
    {
        $menu = $this->category->find($menuId);

        $data = [
            'modalTitle' => 'Редактирование меню',
            'modalContent' => view('backend.settings.menu.form', [
                'menu' => $menu,
                'formAction' => route('admin.settings.menu.update', [
                    'id' => $menu->id,
                ]),
                'buttonText' => 'Сохранить',

            ])->render()];

        return $this->responseJson($data);
    }

    /**
     * @param Request $request
     * @param $menuId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(Request $request, $menuId)
    {
        $menu = $this->category->find($menuId);
        $menu->name = ['ru' => $request->input('name')];
        $menu->save();

        $menus = $this->category->where('owner', 'master-menu')->get();

        return $this->responseJson([
            'functions' => ['updateBlock', 'closeModal'],
            'targetModal' => '#regularModal',
            'blockId' => '#menusList',
            'blockData' => view('backend.settings.menu.list', [
                'menus' => $menus
            ])->render(),
            'success' => 'Меню добавлено'
        ]);
    }

    public function view($masterMenuId)
    {
        $masterMenu = $this->category->find($masterMenuId);

        $categoriesTree = $this->category->where('owner', 'menu-item-' . $masterMenuId)->defaultOrder()->get()->toTree();

        $menuHtml =  $this->buildCategoriesForMenu($categoriesTree, $masterMenuId);

        return view('backend.settings.menu.show', [
            'menuHtml' => $menuHtml,
            'masterMenu' => $masterMenu,
            'title' => 'Настройка меню'
        ]);
    }

    public function itemCreate($masterMenuId)
    {
        $categoriesTree = $this->category->where('owner', 'menu-item-' . $masterMenuId)->get()->toTree();

        $categoriesForSelect = $this->buildCategoriesForSelect($categoriesTree, $masterMenuId);

        $data = [
            'modalTitle' => 'Добавление меню',
            'modalContent' => view('backend.settings.menu.item_form', [
                'categoriesForSelect' => $categoriesForSelect,
                'formAction' => route('admin.settings.menu.item.store', ['masterId' => $masterMenuId]),
                'buttonText' => 'Сохранить',
            ])->render()];

        return $this->responseJson($data);
    }

    public function itemStore(MenuRequest $request, $masterMenuId)
    {
        $array = [
            'parent_id' => $request->category_id,
            'name' => $request->name,
            'url' => $request->url,
            'owner' => 'menu-item-' . $masterMenuId,
            'handler' => $request->handler,
            'target' => ($request->has('target')) ? 1 : 0
        ];

        $this->category->create($array);

        $categoriesTree = $this->category->where('owner', 'menu-item-' . $masterMenuId)->defaultOrder()->get()->toTree();

        $menuHtml =  $this->buildCategoriesForMenu($categoriesTree, $masterMenuId);

        return $this->responseJson([
            'functions' => ['updateBlock', 'closeModal'],
            'targetModal' => '#largeModal',
            'blockId' => '#menusList',
            'blockData' => $menuHtml,
            'success' => 'Меню добавлено'
        ]);
    }

    public function itemEdit($masterMenuId, $itemId)
    {
        $category = $this->category->find($itemId);

//        $categoriesTree = $this->category->where('owner', 'menu-item-' . $masterMenuId)->get()->toTree();
//        $categoriesForSelect = $this->buildCategoriesForSelect($categoriesTree);

        $data = [
            'modalTitle' => 'Редактирование меню',
            'modalContent' => view('backend.settings.menu.item_form', [
                'category' => $category,
                //'categoriesForSelect' => $categoriesForSelect,
                'is_create' => false,
                'formAction' => route('admin.settings.menu.item.update', [
                    'masterMenuId' => $masterMenuId,
                    'itemId' => $itemId
                ]),
                'buttonText' => 'Изменить',

            ])->render()];

        return $this->responseJson($data);
    }

    public function itemUpdate(Request $request, $masterMenuId, $itemId)
    {
        $category = $this->category->find($itemId);

        $category->name = $request->input('name');
        $category->url = $request->input('url');
        //$category->parent_id = $request->input('category_id');
        $category->handler = $request->handler;
        $category->target = ($request->has('target')) ? 1 : 0;
        $category->save();

        $categoriesTree = $this->category->where('owner', 'menu-item-' . $masterMenuId)->defaultOrder()->get()->toTree();

        $menuHtml = $this->buildCategoriesForMenu($categoriesTree, $masterMenuId);

        return $this->responseJson([
            'functions' => ['updateBlock', 'closeModal'],
            'targetModal' => '#largeModal',
            'blockId' => '#menusList',
            'blockData' => $menuHtml,
            'success' => 'Меню изменено'
        ]);
    }

    public function up($masterMenuId, $itemId)
    {
        $category = $this->category->find($itemId);
        $category->up();

        $categoriesTree = $this->category
            ->where('owner', 'menu-item-' . $masterMenuId)
            ->defaultOrder()
            ->get()
            ->toTree();

        $menuHtml = $this->buildCategoriesForMenu($categoriesTree, $masterMenuId);

        $data = [
            'functions' => ['updateBlock', 'closeModal'],
            'targetModal' => '#largeModal',
            'blockId' => '#menusList',
            'blockData' => $menuHtml,
            'success' => 'Меню изменено'
        ];

        return $this->responseJson($data);
    }

    public function down($masterMenuId, $itemId)
    {
        $category = $this->category->find($itemId);
        $category->down();

        $categoriesTree = $this->category->where('owner', 'menu-item-' . $masterMenuId)->defaultOrder()->get()->toTree();

        $menuHtml = $this->buildCategoriesForMenu($categoriesTree, $masterMenuId);

        return $this->responseJson([
            'functions' => ['updateBlock', 'closeModal'],
            'targetModal' => '#largeModal',
            'blockId' => '#menusList',
            'blockData' => $menuHtml,
            'success' => 'Меню изменено'
        ]);
    }

    public function itemDestroy($masterMenuId, $itemId)
    {
        $menu = $this->category->find($itemId);
        $menu->delete();
        $categoriesTree = $this->category->where('owner', 'menu-item-' . $masterMenuId)->defaultOrder()->get()->toTree();

        $menuHtml = $this->buildCategoriesForMenu($categoriesTree, $masterMenuId);

        return $this->responseJson([
            'functions' => ['updateBlock', 'closeModal'],
            'targetModal' => '#largeModal',
            'blockId' => '#menusList',
            'blockData' => $menuHtml,
            'success' => 'Меню изменено'
        ]);
    }

    public function footerUpdate(Request $request,Footer $footer)
    {
        $request->merge([
            'site_display' => $request->input('site_display')
        ]);
        $footer->create($request->all());
    }
}
