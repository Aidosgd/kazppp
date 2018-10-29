<?php

namespace App\Http\Controllers\Backend\Users\Admins;


use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Backend\UsersAdminRequest;
use App\Models\Admin;
use App\Models\Role;
use DebugBar;
use Exception;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\ExpectationFailedException;

class AdminController extends Controller
{
    use ResponseTrait;

    private $admin;
    private $role;

    public function __construct(Admin $admin, Role $role)
    {
        $this->admin = $admin;
        $this->role = $role;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $roles = $this->role->orderBy('name')->get();
        return view('backend.users.admins.index', [
            'title' => 'Список администраторов',
            'roles' => $roles
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function getList(Request $request)
    {
        $users = $this->admin->orderBy('active', 'desc')->orderBy('super_user')->paginate(20);

        return response()->json([
            'tableData' => view('backend.users.admins.list', [
                'users' => $users,
                'filters' => $request->all()
            ])->render(),
            'pagination' => view('backend.common.pagination', [
                'links' => $users->links('vendor.pagination.bootstrap-4'),
            ])->render(),
        ]);

    }

    public function store(UsersAdminRequest $request, Admin $admin)
    {

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        $user = $admin->create([
            'email' => $email,
            'name' => $name,
            'password' => $password,
            'active' => 1,
        ]);

        if ($request->has('roles')) {
            $user->roles()->sync(array_keys($request->input('roles')));
        }

        return response()->json([
            'functions' => ['closeModal'],
            'modal' => '#largeModal',
            'type' => 'prepend-table-row',
            'table' => '#ajaxTable',
            'content' => view('backend.users.admins.item', ['user' => $user])->render()
        ]);


    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function create()
    {
        $roles = $this->role->orderBy('name')->get();


        return response()->json([
            'type' => 'updateModal',
            'modal' => '#largeModal',
            'modalTitle' => 'Создание администратора',
            'modalContent' => view('backend.users.admins.form', [
                'roles' => $roles,
                'formAction' => route('admin.users.admins.store'),
                'buttonText' => 'Создать'
            ])->render()
        ]);
    }

    /**
     * @param $userId
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function edit($userId)
    {
        $user = $this->admin->with('roles.permissions.group')->find($userId);
        $roles = $this->role->orderBy('name')->get();
        $userRolesIds = $user->roles()->pluck('id')->toArray();


        return response()->json([
            'type' => 'updateModal',
            'modal' => '#largeModal',
            'modalTitle' => 'Редактирование администратора',
            'modalContent' => view('backend.users.admins.form', [
                'user' => $user,
                'roles' => $roles,
                'userRolesIds' => $userRolesIds,
                'formAction' => route('admin.users.admins.update', ['id' => $userId]),
                'buttonText' => 'Сохранить',
            ])->render()
        ]);
    }

    public function update(UsersAdminRequest $request, $userId)
    {
        $user = $this->admin->find($userId);
        $user->email = $request->input('email');
        $user->name = $request->input('name');
        if ($request->has('password')) {
            $user->password = $request->input('password');
        }

        if ($request->has('active')) {
            $user->active = 1;
        } else {
            $user->active = 0;
        }

        $user->save();

        if ($request->has('roles')) {
            $user->roles()->sync(array_keys($request->input('roles')));
        } else {
            $user->roles()->sync([]);
        }

        return response()->json([
            'functions' => ['updateTableRow', 'closeModal'],
            'modal' => '#largeModal',
            'type' => 'update-table-row',
            'table' => '#ajaxTable',
            'row' => '.row-' . $userId,
            'content' => view('backend.users.admins.item', ['user' => $user])->render()
        ]);
    }



}
