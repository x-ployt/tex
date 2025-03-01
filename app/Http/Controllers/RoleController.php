<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleValidation;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Redirect to the role page.
     */
    public function index()
    {
        $roles = Role::all();
        return view ('navigation.employee_maintenance.role.index', compact('roles'));
    }

    /**
     * View role
     */
    public function view(Role $branch) {
        return view('navigation.role.view', compact('role'));
    }

    /**
     * Add role
     */
    public function addRole(RoleValidation $request)
    {
        $data = $request->validated();
        Role::create($data);
        return redirect()->back()->with('addSuccess', 'Add success');
    }

    /**
     * Update role
     */
    public function updateRole(RoleValidation $request, Role $role)
    {
        $data = $request->validated();
        $role->update($data);
        return redirect()->back()->with('updateSuccess', 'Update success')->with('role_id', $role->id);
    }
}
