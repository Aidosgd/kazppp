<?php namespace App\Services;

use App\Models\Category;
use Illuminate\Http\Request;


class CategoryService {

    private $category;
    private $cats = [];
    private $strCats = '';

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function get($id)
    {
        return $this->category->find($id);
    }

    public function create(Request $request)
    {
        $category = $this->category->create([
            'owner' => $request->input('owner'),
            'name' => $request->input('name')
        ]);

        if ($request->get('parent_id')) {
            $parent = $this->category->find($request->get('parent_id'));
            $this->category->find($category->id)->appendToNode($parent)->save();
        }

        return $category;
    }

    public function update(Request $request, $categoryId)
    {
        $category = $this->category->find($categoryId);

        $category->name = $request->input('name');
        $category->save();

        if ($request->input('parent_id')) {
            $parent = $this->category->find($request->input('parent_id'));
            $category->appendToNode($parent)->save();
        }
    }

    public function destroy(Request $request, $categoryId)
    {
        $category = $this->category
            ->with('ancestors')
            ->with('descendants')
            ->find($categoryId);

        $descendants = $category->descendants;
        $ancestors = $category->ancestors;

        if ($descendants->count()) {
            if ($ancestors->count()) {
                $descendants->first()->appendToNode($ancestors->last())->save();
            } else {
                $descendants->first()->makeRoot()->save();
            }
        }

//        foreach ($category as $ownerCat) {
//            dd($category);
//            $ownerCat->category_id = $request->get('category_id');
//            $ownerCat->save();
//        }

        $category->delete();

    }

    public function up($categoryId)
    {
        $category = $this->category->find($categoryId);
        $category->up();
    }

    public function down($categoryId)
    {
        $category = $this->category->find($categoryId);
        $category->down();
    }

    public function categoriesForList($owner)
    {
        return $this->buildCategoriesForList($owner);
    }

    public function categoriesForSelect($owner)
    {
        return $this->buildCategoriesForSelect($owner);
    }

    public function getTree($owner)
    {
        return $this->category->where('owner', $owner)->defaultOrder()->get()->toTree();
    }

    private function buildCategoriesForSelect($owner)
    {
        $categories = $this->getTree($owner);

        foreach ($categories as $category)
        {
            $this->cats[$category->id] = $category->name ;
            $this->getChildOptions($category);
            $this->depth = 0;
        }
        return $this->cats;
    }

    private function getChildOptions($category, $depth = 1)
    {
        foreach ($category->children as $k => $child)
        {
            $str = $this->getLines($depth);
            $this->cats[$child->id] = $str . $child->name;
            $this->getChildOptions($child, $depth+1);
        }
        return $this->cats;
    }

    private function buildCategoriesForList ($owner)
    {
        $categories = $this->getTree($owner);

        $this->strCats  .= '<ul class="list-group">';
        foreach ($categories as $category)
        {
            $this->strCats  .= '<li class="list-group-item">';
            $this->strCats  .= '<a class="handle-click" data-type="ajax-get" href="'.route("admin.categories.edit",['owner' => $owner, 'categoryId' => $category->id]).'">' . $category->name . '</a>';
            $this->strCats  .= '<span class="pull-right">';
            $this->strCats  .= '<div class="btn-group" role="group">' ;
            $this->strCats  .= '<a href="' . route('admin.categories.up', ['categoryId' => $category->id, 'owner' => $owner]) . '" class="btn btn-default btn-sm handle-click" data-type="ajax-get"><i class="fa fa-arrow-up"></i></a>' ;
            $this->strCats  .= '<a href="' . route('admin.categories.down', ['categoryId' => $category->id, 'owner' => $owner]) . '" class="btn btn-default btn-sm handle-click" data-type="ajax-get"><i class="fa fa-arrow-down"></i></a>' ;
            $this->strCats  .= '<a href="' . route('admin.categories.destroy', ['categoryId' => $category->id, 'owner' => $owner]) . '"class="handle-click btn btn-default btn-sm" data-type="confirm"
    data-confirm-title="Удаление"
    data-confirm-message="Вы уверены, что хотите удалить"
    data-cancel-text="Нет"
    data-confirm-text="Да, удалить" 
    data-follow-url="true" 
    href="/messages/45/delete"><i class="fa fa-trash-o"></i></a>' ;
            $this->strCats  .= '</div>' ;
            $this->strCats  .= '</span>' ;
            $this->strCats  .= '</li>' ;
            $this->getChildCats($category, $owner);
            $this->depth = 0;
        }

        $this->strCats  .= '</ul>';
        return $this->strCats;
    }

    private function getChildCats($category, $owner, $depth = 1)
    {
        foreach ($category->children as $k => $child)
        {
            $margin = $depth * 10;
            $str = $this->getLines($depth);
            $this->strCats  .= '<li class="list-group-item" style="margin-left: ' . $margin . 'px">';
            $this->strCats  .= '<a class="handle-click" data-type="ajax-get" href="' .route("admin.categories.edit",['owner' => $owner, 'categoryId' => $child->id]).'">'. $child->name .'</a>';
            $this->strCats  .= '<span class="pull-right">';
            $this->strCats  .= '<div class="btn-group" role="group">' ;
            $this->strCats  .= '<a href="' . route('admin.categories.up', ['categoryId' => $child->id, 'owner' => $owner]) . '" class="btn btn-default btn-sm handle-click" data-type="ajax-get"><i class="fa fa-arrow-up"></i></a>' ;
            $this->strCats  .= '<a href="' . route('admin.categories.down', ['categoryId' => $child->id, 'owner' => $owner]) . '" class="btn btn-default btn-sm handle-click" data-type="ajax-get"><i class="fa fa-arrow-down"></i></a>' ;
            $this->strCats  .= '<a href="' . route('admin.categories.destroy', ['categoryId' => $child->id, 'owner' => $owner]) . '"class="handle-click btn btn-default btn-sm" data-type="confirm" data-confirm-title="Удаление"  data-confirm-message="Вы уверены, что хотите удалить"
    data-cancel-text="Нет"
    data-confirm-text="Да, удалить" 
    data-follow-url="true" 
    href="/messages/45/delete"><i class="fa fa-trash-o"></i></a>' ;
            $this->strCats  .= '</div>' ;
            $this->strCats  .= '</span>' ;
            $this->strCats  .= '</li>' ;
            $this->cats[$child->id] = $str . $child->name;
            $this->getChildCats($child,  $owner,$depth+1);
        }
        return $this->cats;
    }

    private function getLines($count)
    {
        $str = '';
        for ($i = 0; $i < $count; $i++)
        {
            $str .= '-';
        }
        return $str;
    }


}