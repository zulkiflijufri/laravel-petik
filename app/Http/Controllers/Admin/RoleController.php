<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleUpdateRequest;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:roles.index|roles.create|roles.edit|roles.delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::latest()->when(request()->q,
        function($roles) {
            $roles = $roles->where('name', 'like', '%' . request()->q . '%');
        })->paginate(5);

        return view('admin.role.index', compact('roles'));
        // dd('Hello');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::latest()->get();
        return view('admin.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create([
            'name' => $request->input('name')
        ]);

        // assign permission to role
        $role->syncPermissions($request->input('permissions'));

        if ($role) {
            return redirect()->route('admin.role.index')->with(['success' => 'Data berhasil disimpan!']);
        } else {
            return redirect()->route('admin.role.index')->with(['success' => 'Data gagal disimpan!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::latest()->get();
        return view('admin.role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RoleUpdateRequest  $request
     * @param  int  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $role = Role::findOrFail($role->id);
        $role->update([
            'name' => $request->input('name')
        ]);

        // assign permission to role
        $role->syncPermissions($request->input('permissions'));

        if ($role) {
            return redirect()->route('admin.role.index')->with(['success' => 'Data berhasil diupdate!']);
        } else {
            return redirect()->route('admin.role.index')->with(['success' => 'Data gagal diupdate!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $permissions = $role->permissions;
        $role->revokePermissionTo($permissions);
        $role->delete();

        if ($role) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
