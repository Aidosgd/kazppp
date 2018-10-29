<?php

namespace App\Http\Requests\Backend\Core;

use App\Http\Requests\MessagesTrait;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;


class WysiwygRequest extends FormRequest
{
    use MessagesTrait;

    /**
     *
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
        /**
         * Создание папки в визивиге
         *
         */
        if ($this->segment(3) == 'wysiwyg' && $this->segment(4) == 'folder' && $this->segment(5) == 'store')
        {
           return [
               'name' => 'required'
           ];
        }


    }
}
