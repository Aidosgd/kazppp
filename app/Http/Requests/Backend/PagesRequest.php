<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\MessagesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PagesRequest extends FormRequest
{
    use MessagesTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('admins')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title.ru'=>'required',
            'content.ru'=>'required',
        ];
    }
}
