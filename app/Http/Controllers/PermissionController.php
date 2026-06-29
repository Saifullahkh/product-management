<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role:Enterprise User', only: ['index', 'store', 'update', 'destroy']),
        ];
    }

    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.create', ['permissions' => $permissions]);
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3',
        ]);

        if ($data->passes()) {
            Permission::create(['name' => $request->name]);
            return redirect()->route('permissions-index')->with('success', 'Permission Created Successfully!');
        }

        return redirect()->back()->withErrors($data);
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        $permission->name = $request->name;
        if ($permission->save()) {
            return redirect()->route('permissions-index')->with('info', 'Permission Updated Successfully!');
        }
    }

    public function destroy($id)
    {
        Permission::destroy($id);
        return redirect()->route('permissions-index')->with('warning', 'Permission Deleted Successfully!');
    }
}
