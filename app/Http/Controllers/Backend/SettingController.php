<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    private $setting;
    private $category;

    public function __construct(Setting $setting, Category $category)
    {
        $this->setting = $setting;
        $this->category = $category;
    }

    public function menu()
    {
        $setting = $this->setting->where('alias', 'menu')->first();

        $menus = ($setting) ? $setting->data : [];
        $rootMenus = $this->category->where('owner', 'master-menu')->get();

        return view('backend.settings.manage.menu.index', [
            'title' => 'Настройка меню',
            'menus' => $menus,
            'rootMenus' => $rootMenus
        ]);
    }

    public function menuUpdate(Request $request)
    {
        $menus = config('project.menus');

        $requestData = $request->input('menu');

        if (is_array($menus))
        {
            foreach ($menus as $type => $menu)
            {
                $menus[$type]['slug'] = $requestData[$type]['slug'];
            }
        }

        $setting = $this->setting->where('alias', 'menu')->first();
        $setting->data = json_encode($menus);
        $setting->save();

        return redirect()->route('admin.menu.manage');
    }

    public function footer()
    {
        $foreign_languages = config('project.foreign_locales');
        $setting = $this->setting->where('alias', 'footer_text')->first();

        $footer = $setting->data;

        return view('backend.settings.manage.footer.index', [
            'title' => 'Настройка футера',
            'foreign_languages'=>$foreign_languages,
            'footer'=>$footer
        ]);
    }

    public function footerUpdate(Request $request)
    {
        $requestData = $request->input('footer_text');

        $setting = $this->setting->where('alias', 'footer_text')->first();
        $setting->data = json_encode($requestData);
        $setting->save();

        return redirect()->route('admin.footer.manage');
    }

}
