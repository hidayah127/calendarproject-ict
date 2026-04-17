<?php

namespace App\Http\Controllers\Head;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class StaffDepartmentController extends Controller
{
    
    public function index()
    {
        $departmentId = Auth::user()->staff->department_id;

        $staff = Staff::where('department_id', $departmentId)->get();

        return view('Head.Department-Staff', compact('staff'));
    }


    /**
     * Store new department staff
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'staff_id' => 'required|unique:staff,staff_id',
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:staff,email',
    //         'position' => 'nullable|string|max:255',
    //     ]);

    //     $departmentId = Auth::user()->staff->department_id;

    //     Staff::create([
    //         'staff_id' => $request->staff_id,
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'position' => $request->position,
    //         'department_id' => $departmentId,
    //         'is_active' => true
    //     ]);

    //     return redirect()
    //         ->route('head.staff.index')
    //         ->with('success', 'Staff added successfully');
    // }


    /**
     * Update staff information
     */
    // public function update(Request $request, $id)
    // {
    //     $staff = Staff::findOrFail($id);

    //     $departmentId = Auth::user()->staff->department_id;

    //     if ($staff->department_id != $departmentId) {
    //         abort(403, 'Unauthorized action.');
    //     }

    //     $request->validate([
    //         'staff_id' => 'required',
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email',
    //         'position' => 'nullable|string|max:255',
    //     ]);

    //     $staff->update([
    //         'staff_id' => $request->staff_id,
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'position' => $request->position,
    //     ]);

    //     return redirect()
    //         ->route('head.staff.index')
    //         ->with('success', 'Staff updated successfully');
    // }


    /**
     * Delete staff
     */
    // public function destroy($id)
    // {
    //     $staff = Staff::findOrFail($id);

    //     $departmentId = Auth::user()->staff->department_id;

    //     if ($staff->department_id != $departmentId) {
    //         abort(403, 'Unauthorized action.');
    //     }

    //     $staff->delete();

    //     return redirect()
    //         ->route('head.staff.index')
    //         ->with('success', 'Staff deleted successfully');
    // }

}
