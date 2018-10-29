<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\XMLHttpRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use JSON;

class MainController extends Controller
{
    public function index(){

        return view('pages.welcome');
    }
}
