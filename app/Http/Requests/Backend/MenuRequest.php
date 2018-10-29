<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\MessagesTrait;
use Illuminate\Foundation\Http\FormRequest;

use Auth;

class MenuRequest extends FormRequest
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
        if ($this->segment('3') == 'menu' && $this->segment(4) == 'store')
        {
            return [
                'name' => 'required'
            ];
        }

        if ($this->segment('3') == 'menu' && $this->segment(5) == 'update')
        {
            return [
                'name' => 'required'
            ];
        }

        if ($this->segment('3') == 'menu' && $this->segment(5) == 'submenu' && $this->segment(6) == 'store')
        {
            return [
                'name.*' => 'required'
            ];
        }

        if ($this->segment('2') == 'menu' && $this->segment(5) == 'submenu' && $this->segment(7) == 'update')
        {
            return [
                'name.*' => 'required'
            ];
        }
    }
}
