<?php

namespace App\Http\Controllers;

use App\Http\Requests\BranchValidation;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Redirect to the branch page.
     */
    public function index()
    {
        $branches = Branch::all();
        return view ('navigation.branch.index', compact('branches'));
    }

    /**
     * View branch
     */
    public function view(Branch $branch) {
        return view('navigation.branch.view', compact('branch'));
    }

    /**
     * Add branch
     */
    public function addBranch(BranchValidation $request)
    {
        $data = $request->validated();
        Branch::create($data);
        return redirect()->back()->with('addSuccess', 'Add success');
    }

    /**
     * Update branch
     */
    public function updateBranch(BranchValidation $request, Branch $branch)
    {
        $data = $request->validated();
        $branch->update($data);
        return redirect()->back()->with('updateSuccess', 'Update success')->with('branch_id', $branch->id);
    }
}
