<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\User;
use App\Models\Department;
use App\Models\PasswordResetRequest;
use Illuminate\Support\Facades\Hash;

class AccessUserController extends Controller
{

    // Admin reset password to default password
    const DEFAULT_PASSWORD = 'Free@gaza';

    public function index()
    {

        $users = User::with('staff.department', 'accessibleDepartments')->get();

        $departments = Department::orderBy('name')->get();

         $pendingResets = PasswordResetRequest::with('user')
            ->pending()
            ->latest()
            ->get();

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

    /**
     * Reset a user's password back to the shared default.
     * Resolves any pending forgot-password request tied to this user.
     */
    public function resetPasswordToDefault(User $user)
    {
        $user->password = Hash::make(self::DEFAULT_PASSWORD);
        $user->save();

        PasswordResetRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->update([
                'status'      => 'resolved',
                // 'resolved_by' => auth()->id(),
                'resolved_at' => now(),
            ]);

        return back()->with(
            'success',
            "Password for {$user->name} has been reset to the default password. Please inform them to log in and change it."
        );
    }
}
