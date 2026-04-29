<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::with('department')->get();
        $departments = Department::all();

        return view('Admin.staff', compact('staff','departments'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => ['required', 'unique:staff', 'regex:/^FP\d{5}$/'],
            'name' => 'required',
            'email' => 'required|email',
            'department_id' => 'required'
        ], [
            'staff_id.required' => 'Staff ID is required.',
            'staff_id.regex' => 'Staff ID must be FP followed by 5 digits (e.g. FP04428).',
            'staff_id.unique' => 'Staff ID already exists.',
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',
            'department_id.required' => 'Please select a department.',
            'position.required' => 'Please select a position.'
        ]);

        Staff::create([
            'staff_id' => $request->staff_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'position' => $request->position,
            'department_id' => $request->department_id
        ]);

        return redirect()->route('admin.staff.index')
            ->with('success','Staff created successfully');
    }


    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $request->validate([
            'staff_id' => ['required', 'regex:/^FP\d{5}$/', 'unique:staff,staff_id,' . $id],
            'name' => 'required',
            'email' => 'required|email',
            'department_id' => 'required'
        ]);

        $staff->update([
            'staff_id' => $request->staff_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'position' => $request->position,
            'department_id' => $request->department_id
        ]);

        return redirect()->route('admin.staff.index')
            ->with('success','Staff updated successfully');
    }


    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);

        $staff->delete();

        return redirect()->route('admin.staff.index')
            ->with('success','Staff deleted');
    }

    public function giveAccess(Request $request, $id)
    {

        $request->validate([
            'role' => 'required|in:admin,vc,hd,ld,az'
        ]);

        $staff = Staff::findOrFail($id);

        // Create a user account for the staff
        User::create([
            'name' => $staff->name,
            'username' => $staff->staff_id, // Use staff_id as username
            'email' => $staff->email,
            'password' => Hash::make('Free@gaza'), // Set a default password or generate one
            'role' => $request->role, // Set the role to staff
            'staff_id' => $staff->id
        ]);

        return redirect()->route('admin.staff.index')
            ->with('success','Access granted to staff');
    }

    public function removeAccess($id)
    {
        $staff = Staff::findOrFail($id);

        // Find the user account associated with the staff and delete it
        $user = User::where('staff_id', $staff->id)->first();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.staff.index')
            ->with('success','Access revoked from staff');
    }

    // Import staff from CSV file
    public function importCSV(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = fopen($request->file('file')->getRealPath(), 'r');

        // Skip header
        fgetcsv($file);

        $count = 0;
        $skipped = 0;

        while (($row = fgetcsv($file)) !== FALSE) {

            //Find department by name
            // $department = Department::where('name', $row[5])->first();
            // if (!$department) {
            //     $skipped++;
            //     continue; // Skip if department not found
            // }

            //FIND DEPARTMENT BY NAME (PUT HERE)
            $department = Department::whereRaw(
                'LOWER(name) = ?',
                [strtolower(trim($row[5]))]
            )->first();

            // If department not found → skip
            if (!$department) {
                $skipped++;
                continue;
            }

            // Skip duplicate staff_id
            if (Staff::where('staff_id', $row[0])->exists()) {
                $skipped++;
                continue;
            }

            Staff::create([
                'staff_id'      => $row[0],
                'name'          => $row[1],
                'email'         => $row[2],
                'phone'         => $row[3] ?? null,
                'position'      => $row[4],
                'department_id' => $department->id,
            ]);

            $count++;
        }

        fclose($file);

        return redirect()->route('admin.staff.index')
            ->with('success','Staff imported successfully. ' . $skipped . ' rows skipped.');
    }
}
