<?php

namespace App\Http\Controllers\BackendAPI\Examples;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JSON;
use App\Models\Contact;

/**
 * Класс для работы с домашней страницей
 *
 * Class HomeController
 * @package App\Http\Controllers\BackendAPI\Examples
 */
class HomeController extends Controller
{

    public function allContacts()
    {
        // Контакты для главной страницы
        $contacts = Contact::all();

        return JSON::success(
            compact('contacts')
        );
    }

    public function twoContacts()
    {
        // Контакты для главной страницы
        $contacts = Contact::all()->take(2);

        return JSON::success(
            compact('contacts')
        );
    }
}
