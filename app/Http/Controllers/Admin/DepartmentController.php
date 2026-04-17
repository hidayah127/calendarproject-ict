<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();

        return view('Admin.department', compact('departments'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'nullable|unique:departments'
        ]);

        Department::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description
        ]);

        return redirect()->route('admin.departments.index')
            ->with('success','Department created successfully');
    }


    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $department->update([
            'name' => $request->name,
            'code' => $request->code
        ]);

        return redirect()->route('admin.departments.index')
            ->with('success','Department updated');
    }


    public function destroy($id)
    {
        $department = Department::findOrFail($id);

        $department->delete();

        return redirect()->route('admin.departments.index')
            ->with('success','Department deleted');
    }
}
