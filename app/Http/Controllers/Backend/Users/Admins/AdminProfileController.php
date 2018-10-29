<?php

namespace App\Http\Controllers\Backend\Users\Admins;

use App\Http\Requests\Backend\UsersAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ResponseTrait;

class AdminProfileController extends Controller
{
    use ResponseTrait;


    private $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }
    public function profile()
    {
            $userId = Auth::guard('admins')->user()->id;

            return view('backend.users.admins.profile', [
                'title' => 'Профиль',
                'formAction' => route('admin.users.admins.profile.update'),
                'buttonText' => 'Изменить'
            ]);
    }

    public function update(Request $request)
    {
        $userId = Auth::guard('admins')->id();
        $user = $this->admin->find($userId);
        $user->email = $request->input('email');
        $user->name = $request->input('name');
        if ($request->has('password')) {
            $user->password = $request->input('password');
        }

        $user->save();
        return $this->responseJson([
            'message' => ['header' => 'successful!',
                'message' => 'Профиль успешно изменен',
                'type' => 'success']]);
    }
}
