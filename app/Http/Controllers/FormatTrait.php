<?php namespace App\Http\Controllers;

trait FormatTrait
{
    private $cats = [];
    private $strCats = '';

    protected function buildCategoriesForSelect($categories): array
    {
        foreach ($categories as $category)
        {
            $this->cats[$category->id] = $category->name ;
            $this->getChildOptions($category);

            $this->depth = 0;
        }

        return $this->cats;
    }

    protected function getChildOptions($category, $depth = 1)
    {

        foreach ($category->children as $k => $child)
        {
            $str = $this->getLines($depth);
            $this->cats[$child->id] = $str . $child->title;

            $this->getChildOptions($child, $depth+1);
        }

        return $this->cats;
    }

    protected function getLines($count)
    {
        $str = '';

        for ($i = 0; $i < $count; $i++)
        {
            $str .= '-';
        }

        return $str;
    }

    public function buildCategoriesForMenu($categories, $masterMenuId)
    {
        $this->strCats .= '<ul class="list-group">';
        foreach ($categories as $category)
        {
            $this->strCats .= '<li class="list-group-item">';
            if ($category->parent_id)
            {
                $this->strCats .= '<a class="has-modal-content" data-modal="#largeModal" data-modal-content-url="' . route('admin.settings.menu.item.edit', ['masterMenuId' => $masterMenuId, 'catId' => $category->id]) . '" href="'. $category->name .'">'. $category->name .'</a>';
            } else {
                $this->strCats .= '<a class="has-modal-content" data-modal="#largeModal" data-modal-content-url="' . route('admin.settings.menu.item.edit', ['masterMenuId' => $masterMenuId, 'catId' => $category->id]) . '" href="'. $category->name .'">'. $category->name .'</a>';

                $this->strCats .= '<span class="pull-right">';
                $this->strCats .= '<div class="btn-group" role="group" aria-label="...">';


                $this->strCats .= '<a href="'. route('admin.settings.menu.up', ['menuId'=> $masterMenuId,'id' => $category->id]) .'"  class="btn btn-default btn-sm up-menu-item"><i class="fa fa-arrow-up"></i></a>';
                $this->strCats .= '<a href="'. route('admin.settings.menu.down', ['menuId' => $masterMenuId, 'id' => $category->id]) .'" class="btn btn-default btn-sm down-menu-item"><i class="fa fa-arrow-down"></i></a>';
                $this->strCats .= '<a href="' . route('admin.settings.menu.destroy', ['menuId' => $masterMenuId, 'id' => $category->id]) .  '" class="btn btn-default btn-sm delete-menu-item"><i class="la la-trash"></i></a>';
                $this->strCats .= '</div>';
                $this->strCats .= '</span>';
            }

            $this->strCats .= '</li>';

            $this->getChildrenForMenu($category, $masterMenuId);

            $this->depth = 0;
        }

        $this->strCats .= '</ul>';

        return $this->strCats;
    }

    public function getChildrenForMenu($category, $masterMenuId, $depth = 1)
    {
        foreach ($category->children as $k => $child)
        {
            $margin = $depth * 15;
            $str = $this->getLines($depth);
            $this->strCats .= '<li class="list-group-item" style="margin-left: '. $margin .'px">';
            $this->strCats .= '<a class="has-modal-content" data-modal="#largeModal" data-modal-content-url="' . route('admin.settings.menu.item.edit', ['masterMenuId' => $masterMenuId, 'catId' => $child->id]) . '" href="'. $child->url .'">' . $child->name . '</a>';
            $this->strCats .= '<span class="pull-right">';
            $this->strCats .= '<div class="btn-group" role="group" aria-label="...">';


            $this->strCats .= '<a href="'. route('admin.settings.menu.up', ['menuId'=> $masterMenuId,'id' => $child->id]) .'"  class="btn btn-default btn-sm up-menu-item"><i class="fa fa-arrow-up"></i></a>';
            $this->strCats .= '<a href="'. route('admin.settings.menu.down', ['menuId' => $masterMenuId, 'id' => $child->id]) .'" class="btn btn-default btn-sm down-menu-item"><i class="fa fa-arrow-down"></i></a>';
            $this->strCats .= '<a href="' . route('admin.settings.menu.destroy', ['menuId' => $masterMenuId, 'id' => $child->id]) .  '" class="btn btn-default btn-sm delete-menu-item"><i class="la la-trash"></i></a>';
            $this->strCats .= '</div>';
            $this->strCats .= '</span>';
            $this->strCats .= '</li>';

            $this->cats[$child->id] = $str . $child->name;
            $this->getChildrenForMenu($child, $masterMenuId,$depth+1);
        }

        return $this->cats;
    }
}