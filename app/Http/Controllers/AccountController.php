<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountValidation;
use App\Models\User;
use App\Models\Role;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Redirect to account.index
     */
    public function index() {
        if (Auth::user()->role->role_name === 'SuperAdmin') {
            $roles = Role::all();
            $users = User::where('id', '!=', Auth::id())->get();
            $branches = Branch::all();
        } else {
            $roles = Role::where('role_name', '!=', 'SuperAdmin')->get();
            $users = User::whereHas('role', function ($query) {
                            $query->where('role_name', '!=', 'SuperAdmin');
                        })
                        ->where('branch_id', Auth::user()->branch_id)
                        ->where('id', '!=', Auth::id())
                        ->get();
            $branches = Branch::where('id', Auth::user()->branch_id)->get();
        }
    
        return view('navigation.employee_maintenance.account.index', compact('users', 'roles', 'branches'));
    }    

    /**
     * Redirect to account.view
     */
    public function view(User $user) {
        $roles = Role::all()->skip(1);
        $branches = Branch::all();
        return view('navigation.employee_maintenance.account.view', compact('user', 'roles', 'branches'));
    }

    /**
     * Function to create an account
     */
    public function store(AccountValidation $request) {
        $data = $request->validated();
        $data['password'] = Hash::make("12345678");
        // $data['status'] = 'active';
        User::create($data);
        return redirect()->back()->with('addSuccess', 'Add success');
    }

    /**
     * Function to update an account
     */
    public function update(AccountValidation $request, User $user) {
        $data = $request->validated();
        $user->update($data);  // Update the employee
        return redirect()->back()->with('updateSuccess', 'Update success');
    }

    /**
     * Function to reset password
     */
    public function resetPassword(User $user) {
        $user->update([
            'password' => Hash::make('12345678'),  // Reset password to default value
        ]);
        return redirect()->back()->with('updateSuccess', 'Password has been reset to default successfully.');
    }

}
