<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\LoginRequest;

//Model

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ResponseTrait;

class AuthController extends Controller {
	use ResponseTrait;

	public function __construct( Admin $admin ) {
		$this->admin = $admin;
	}

	public function getLogin() {
		return view( 'backend.auth.login' );
	}

	/**
	 * @param LoginRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function postLogin( LoginRequest $request ) {

		if (!Auth::guard('admins')->attempt([
			'email' => $request->input('email'),
			'password' => $request->input('password'),
			'active' => 1
		])){
			return $this->responseJsonError( [
				'action'       => 'message',
				'message_data' => [
					'header'  => 'ошибка',
					'message' => 'Логин или пароль неверны или админ не активирован',
					'type'    => 'error'
				]
			],'403');
		}

		return $this->responseJson(['redirect_url' => route('admin.home')]);
	}

	public function logout() {
		Auth::guard( 'admins' )->logout();

		return redirect()->route( 'admin.get.login' );
	}
}
