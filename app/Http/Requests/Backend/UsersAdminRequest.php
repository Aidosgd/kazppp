<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\MessagesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UsersAdminRequest extends FormRequest
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

        // user creation

        if ($this->segment(2) == 'users' && $this->segment(4) == 'store') {
            return [
                'name' => 'required',
                'email' => 'required|email|unique:admins,email',
                'password' => 'required'
            ];
        }

        // user update
        if ($this->segment(2) == 'users' && $this->segment(5) == 'update') {
            return [
                'name' => 'required',
                'email' => 'required|email|unique:admins,email,' . $this->segment(4),
            ];
        }
    }
}
