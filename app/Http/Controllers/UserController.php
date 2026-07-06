<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role:Admin', only: ['showUser', 'deleteUser', 'update']),
        ];
    }

    public function showUser()
    {
        $users = User::all();
        $roles = Role::orderBy('name', 'ASC')->get();
        $plans = [
            'price_1Tl0ex5TaCf50YAD6FZs8a54' => 'Enterprise Plan',
            'price_1Tl0dp5TaCf50YADcqrJRwsG' => 'Pro Business Plan',
            'price_1Tl0cP5TaCf50YADJPdhkbHQ' => 'Basic Plan',
        ];
        return view('user', ['users' => $users, 'roles' => $roles, 'plans' => $plans]);
    }

    public function addUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ], [
            'password.confirmed' => 'The password confirmation does not match!.',
            'email.unique' => 'This email is already registered.'
        ]);

        $user = User::create($data);
        if ($user) {
            return redirect()->route('login');
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|string|email',
            'role' => 'nullable|array',
            'role.*' => 'exists:roles,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!$user) {
            return redirect()->route('users')->with('error', 'User not found.');
        }

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();
        $user->syncRoles($request->role ?? []);

        return redirect()->route('users');
    }

    public function deleteUser($id)
    {
        $user = User::destroy($id);
        if ($user) {
            return redirect()->route('users');
        }
    }

    public function loginUser(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('welcome');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
