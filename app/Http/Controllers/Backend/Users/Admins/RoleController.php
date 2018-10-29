<?php

namespace App\Http\Controllers\Backend\Users\Admins;

use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Backend\RoleAdminRequest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// models
use App\Models\PermissionGroup;
use App\Models\Role;

class RoleController extends Controller
{
    use ResponseTrait;
    private $role;
    private $permissionGroup;

    public function __construct(Role $role, PermissionGroup $permissionGroup)
    {
        $this->role = $role;
        $this->permissionGroup = $permissionGroup;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function create()
    {
        $permsGroups = $this->permissionGroup->with('permissions')->get();
        $roles = $this->role->get();



        return response()->json([
            'type' => 'updateModal',
            'modal' => '#largeModal',
            'modalTitle' => 'Роли администраторов',
            'modalContent' => view('backend.users.admins.roles.index', [
                'roles' => $roles,
                'permsGroups' => $permsGroups,
                'formAction' => route('admin.users.admins.roles.store'),
                'buttonText' => 'Создать'
            ])->render()
        ]);

    }


    /**
     * @param RoleAdminRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(RoleAdminRequest $request)
    {
        $role = $this->role->create([
            'owner' => 'admin',
            'name' => $request->input('name')
        ]);
        if ($request->has('perms')) {
            $role->permissions()->sync(array_keys($request->input('perms')));
        }

        $permsGroups = $this->permissionGroup->with('permissions')->get();
        $roles = $this->role->get();

        return response()->json([
            'type' => 'updateModal',
            'modal' => '#largeModal',
            'modalTitle' => 'Роли администраторов',
            'modalContent' => view('backend.users.admins.roles.index', [
                'roles' => $roles,
                'permsGroups' => $permsGroups,
                'formAction' => route('admin.users.admins.roles.store'),
                'buttonText' => 'Создать'
            ])->render()
        ]);


    }



    /**
     * @param $roleId
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function edit($roleId)
    {
        $role = $this->role->find($roleId);
        $roles = $this->role->get();
        $permsGroups = $this->permissionGroup->with('permissions')->get();
        $rolePermIds = $role->permissions->pluck('id')->toArray();


        return response()->json([
            'type' => 'updateModal',
            'modal' => '#largeModal',
            'modalTitle' => 'Роли администраторов',
            'modalContent' => view('backend.users.admins.roles.index', [
                'roles' => $roles,
                'roleItem' => $role,
                'permsGroups' => $permsGroups,
                'rolePermIds' => $rolePermIds,
                'formAction' => route('admin.users.admins.roles.update', ['roleId' => $roleId]),
                'buttonText' => 'Сохранить'
            ])->render()
        ]);

    }

    public function update(RoleAdminRequest $request, $roleId)
    {
        $role = $this->role->where('owner', 'admin')->where('id', $roleId)->first();
        $role->name = $request->input('name');
        $role->save();

        if ($request->has('perms')) {
            $permIds = array_keys($request->input('perms'));
            $role->permissions()->sync($permIds);
        } else {
            $role->permissions()->sync([]);
        }


        $permsGroups = $this->permissionGroup->with('permissions')->get();
        $roles = $this->role->get();

        return response()->json([
            'type' => 'updateModal',
            'modal' => '#largeModal',
            'modalTitle' => 'Роли администраторов',
            'modalContent' => view('backend.users.admins.roles.index', [
                'roles' => $roles,
                'permsGroups' => $permsGroups,
                'formAction' => route('admin.users.admins.roles.store'),
                'buttonText' => 'Создать'
            ])->render()
        ]);

    }
}
