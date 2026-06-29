<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role:Enterprise User', only: ['index', 'store', 'update', 'destroy', 'getPermissions']),
        ];
    }

    public function index()
    {
        $roles       = Role::get();
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('role.create', ['roles' => $roles, 'permissions' => $permissions]);
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3',
        ]);

        if ($data->passes()) {
            $role = Role::create(['name' => $request->name]);
            if (!empty($request->permissions)) {
                foreach ($request->permissions as $permission) {
                    $role->givePermissionTo($permission);
                }
            }
            return redirect()->route('roles-index')->with('success', 'Role Created Successfully!');
        }

        return redirect()->back()->withErrors($data);
    }

    public function update(Request $request, $id)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $id . '|min:3',
        ]);

        if ($data->fails()) {
            return redirect()->back()->withErrors($data);
        }

        $role = Role::find($id);
        $role->name = $request->name;
        if ($role->save()) {
            $role->syncPermissions($request->input('permissions', []));
            return redirect()->route('roles-index')->with('info', 'Role Updated Successfully!');
        }
    }

    public function getPermissions($id)
    {
        $role = Role::findOrFail($id);
        return response()->json(['permissions' => $role->getAllPermissions()->pluck('name')]);
    }

    public function destroy($id)
    {
        Role::destroy($id);
        return redirect()->route('roles-index')->with('warning', 'Role Deleted Successfully!');
    }
}
