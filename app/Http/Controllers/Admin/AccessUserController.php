<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\User;
use App\Models\Department;

class AccessUserController extends Controller
{
    public function index()
    {

        $users = User::with('staff.department', 'accessibleDepartments')->get();

        $departments = Department::orderBy('name')->get();

        return view('Admin.accessUser',compact('users', 'departments'));

    }


    public function destroy($id)
    {

        User::findOrFail($id)->delete();

        return back()->with('success','User access removed');

    }

    public function editAccess(User $user)
    {
        $departments = Department::orderBy('name')->get();

        $user->load('accessibleDepartments');

        return view(
            'Admin.user-access',
            compact(
                'user',
                'departments'
            )
        );
    }

    public function updateAccess(Request $request, User $user)
    {
        $request->validate([
            'department_ids' => 'nullable|array',
            'department_ids.*' => 'exists:departments,id',
        ]);

        $user->accessibleDepartments()->sync(
            $request->department_ids ?? []
        );

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'Department access updated successfully.'
            );
    }
}
