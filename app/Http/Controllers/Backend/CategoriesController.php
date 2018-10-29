<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Http\Controllers\ResponseTrait;
use App\Services\CategoryService;
use Illuminate\Http\Request;


class CategoriesController extends Controller
{
    use ResponseTrait;
    private $categoryService;


    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function create(Request $request)
    {
        return response()->json($this->getAjaxDataForModal($request->input('owner')));
    }

    public function store(Request $request)
    {
        $this->categoryService->create($request);

        return response()->json($this->getAjaxDataForModal($request->input('owner')));
    }

    public function edit($categoryId)
    {
        $category = $this->categoryService->get($categoryId);

        return response()->json($this->getAjaxDataForModal($category->owner, $category));
    }

    public function update(Request $request, $categoryId)
    {
        $this->categoryService->update($request, $categoryId);

        return response()->json($this->getAjaxDataForModal($request->input('owner')));
    }

    public function destroy(Request $request, $categoryId)
    {
        $this->categoryService->destroy($request, $categoryId);

        return response()->json($this->getAjaxDataForModal($request->input('owner')));
    }

    public function up(Request $request, $categoryId)
    {
        $this->categoryService->up($categoryId);

        return response()->json($this->getAjaxDataForModal($request->input('owner')));
    }

    public function down(Request $request, $categoryId)
    {
        $this->categoryService->down($categoryId);

        return response()->json($this->getAjaxDataForModal($request->input('owner')));
    }

    private function getAjaxDataForModal($owner, $category = null)
    {
        $categoriesForSelect = $this->categoryService->categoriesForSelect($owner);
        $categoriesList = $this->categoryService->categoriesForList($owner);

        $route = ($category) ? route('admin.categories.update',
            ['categoryId' => $category->id, 'owner' => $owner]) : route('admin.categories.store', ['owner' => $owner]);

        $data = [
            'type' => 'updateModal',
            'modal' => '#largeModal',
            'modalTitle' => 'Категории',
            'modalContent' => view('backend.common.categories.form', [
                'title' => 'Создание категорий',
                'category' => $category,
                'formAction' => $route,
                'categoriesForSelect' => $categoriesForSelect,
                'categoriesList' => $categoriesList,
                'buttonText' => 'Сохранить',
            ])->render(),
        ];

        return $data;
    }
}
