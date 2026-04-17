<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\User;

class AccessUserController extends Controller
{
    public function index()
    {

        $users = User::with('staff.department')->get();

        return view('Admin.accessUser',compact('users'));

    }


    public function destroy($id)
    {

        User::findOrFail($id)->delete();

        return back()->with('success','User access removed');

    }
}
