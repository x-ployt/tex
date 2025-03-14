<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleValidation;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Redirect to role.index
     */
    public function index()
    {
        $roles = Role::all();
        return view ('navigation.employee_maintenance.role.index', compact('roles'));
    }

    /**
     * Redirect to role.view
     */
    public function view(Role $branch) {
        return view('navigation.role.view', compact('role'));
    }

    /**
     * Function to create a role
     */
    public function addRole(RoleValidation $request)
    {
        $data = $request->validated();
        Role::create($data);
        return redirect()->back()->with('addSuccess', 'Add success');
    }

    /**
     * Function to update a role
     */
    public function updateRole(RoleValidation $request, Role $role)
    {
        $data = $request->validated();
        $role->update($data);
        return redirect()->back()->with('updateSuccess', 'Update success')->with('role_id', $role->id);
    }
}
