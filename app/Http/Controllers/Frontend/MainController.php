<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\XMLHttpRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use JSON;

class MainController extends Controller
{
    public function index(){

        return view('frontend.pages.welcome');
    }

    public function page($slug)
    {
        $page = Page::active()->where('slug', $slug)->first();

        return view('frontend.pages.index', compact('page'));
    }

    public function contacts()
    {
        $page = Page::active()->where('slug', 'kontakty')->first();

        return view('frontend.pages.contacts', compact('page'));
    }
}
