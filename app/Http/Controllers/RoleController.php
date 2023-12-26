<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RoleController extends Controller
{
    public function index()
    {
        $data['list'] = Cache::remember('role-list', 10, function()
        {
            return Role::all();
        });
        //dd($role);
        Cache::put('example-cache', '12345', 3600);
        return view('role/role',$data);
    }

    public function form()
    {
        // Uncomment the following line to check the cache before clearing
        // dd(Cache::get('example-cache'));

        // Clear the cache after displaying the value
        Cache::forget('example-cache');

        return view('role/form');
    }

    public function simpan(Request $post)
    {
        $data = $post->validate([
            'role_name' => 'required|min:3'
        ]);

        $role = new Role;
        $role->role_name = $data['role_name'];
        $role->save();

        return redirect()->route('role.index');
    }

    public function formedit($id_role)
    {
        $data['role'] = Role::find($id_role);
        return view('role/edit', $data);
    }

    public function update(Request $post)
    {
        $data = $post->validate([
            'id' => 'required',
            'role_name' => 'required|min:3'
        ]);

        $role = Role::find($data['id']);
        $role->role_name = $data['role_name'];
        $role->save();

        return redirect()->route('role.index');
    }

    public function delete($id_role)
    {
        $role = Role::find($id_role);
        $role->delete();

        return redirect()->route('role.index');
    }
}
