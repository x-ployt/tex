<?php

namespace App\Http\Controllers;

use App\Http\Requests\RemarkValidation;
use App\Models\Remark;
use Illuminate\Http\Request;

class RemarkController extends Controller
{
    /**
     * Redirect to remark.index
     */
    public function index()
    {
        $remarks = Remark::all();
        return view ('navigation.setting.remark.index', compact('remarks'));
    }

    /**
     * Redirect to remark.view
     */
    public function view(Remark $remark) {
        return view('navigation.setting.remark.view', compact('remark'));
    }

    /**
     * Function to create a remark
     */
    public function store(RemarkValidation $request)
    {
        $data = $request->validated();
        Remark::create($data);
        return redirect()->back()->with('addSuccess', 'Add success');
    }

    /**
     * Function to update a remark
     */
    public function update(RemarkValidation $request, Remark $remark)
    {
        $data = $request->validated();
        $remark->update($data);
        return redirect()->back()->with('updateSuccess', 'Update success')->with('remark_id', $remark->id);
    }
}
