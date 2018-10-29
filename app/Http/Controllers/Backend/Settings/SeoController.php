<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeoController extends Controller
{
    private $setting;

    private $availableParts = [
        'main',
        'news',
    ];

    private $titles = [
        'main' => 'Настройки главной страницы',
        'news' => 'Настройки страницы новостей',
    ];

    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    public function handle(Request $request)
    {
        $part = $request->input('part');

        $data = $this->getData($part);

        $title = $this->titles[$part];

        return view('backend.settings.seo.index', [
            'title' => $title,
            'data' => $data,
            'part' => $part
        ]);
    }

    public function update(Request $request)
    {
        $part = $this->setting->where('alias', $request->input('part'))->first();

        $part->data = json_encode($request->except(['_token', 'part']));
        $part->save();

        return redirect()->route('admin.settings.seo.handle', ['part' => $request->input('part')]);
    }

    public function getData($part)
    {
        if (in_array($part, $this->availableParts))
        {
            $setting = $this->setting->firstOrCreate(['alias' => $part]);

            return $setting->data;
        }

        return null;
    }
}
