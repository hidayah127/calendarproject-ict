<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Department;

class ForgotPasswordController extends Controller
{

    public function index()
    {
        $departments = Department::orderBy('name')->get();

        return view('Auth.forgot-password', compact('departments'));
    }


    public function send(Request $request)
    {

        $request->validate([
            'username' => 'required',
            'department' => 'required',
            'email' => 'required|email',
        ]);


        Mail::raw(
"
AmazingTrack Password Reset Request

Username:
".$request->username."

Department:
".$request->department."

Email:
".$request->email."

Requested Date:
".now()."

Please verify and reset the user's password.
",
        function($message){

            $message->to('hidayah_burhannudin@uptm.edu.my')
                    ->subject('AmazingTrack Password Reset Request');

        });


        return back()->with(
            'success',
            'Password reset request has been sent successfully. ICT will process your request.'
        );
    }

}