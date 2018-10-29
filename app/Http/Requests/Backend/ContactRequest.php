<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\MessagesTrait;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;
class ContactRequest extends FormRequest
{
    use MessagesTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // определяем может ли пользователь отправлять запрос
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
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'photo' => 'image'
        ];
    }
}
