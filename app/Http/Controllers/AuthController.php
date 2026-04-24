<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
   public function login()
    {
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        $request->validate([
            'staff_id' => 'required',
            'password' => 'required'
        ]);

        /*
        |--------------------------------------------------
        | STEP 1 — CHECK SUPER ADMIN FIRST
        |--------------------------------------------------
        */

        $admin = Admin::where(
            'username',
            $request->staff_id
        )->first();

        // dd($admin);
        // dd(Hash::check($request->password, $admin->password));

        if ($admin && Hash::check($request->password, $admin->password)) {

            Auth::guard('admin')->login($admin);

            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        /*
        |--------------------------------------------------
        | STEP 2 — CHECK STAFF
        |--------------------------------------------------
        */

        // find staff using staff_id code
        $staff = Staff::where(
            'staff_id',
            $request->staff_id
        )->first();

        if (!$staff) {
            return back()->with('error','Staff ID not found');
        }

        // find user account linked to staff
        $user = User::where(
            'staff_id',
            $staff->id
        )->first();

        if (!$user) {
            return back()->with('error','No system access assigned');
        }

        // check password
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error','Invalid password');
        }

        Auth::login($user);

        $request->session()->regenerate();

        /*
        |--------------------------------------------------
        | STEP 3 — ROLE BASED REDIRECT
        |--------------------------------------------------
        */

        if ($user->role === 'vc') {
            return redirect()->route('vc.dashboard');
        }

        // if ($user->role === 'hd') {
        //     return redirect()->route('head.dashboard');
        // }

        if (in_array($user->role, ['hd', 'az'])) {
            return redirect()->route('head.dashboard');
        }

        // if ($user->role === 'admin') {
        //     return redirect()->route('admin.dashboard');
        // }

        if ($user->role === 'ld') {
            return redirect()->route('ld.dashboard');
        }

        // fallback
        return redirect()->route('404');
    }
    

    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');

    }
    

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPasswordProcess(Request $request)
    {
        $request->validate([
            'staff_id' => 'required'
        ]);

        // find staff using staff_id code
        $staff = Staff::where('staff_id',$request->staff_id)->first();

        if(!$staff){
            return back()->with('error','Staff ID not found');
        }

        // find user account linked to staff
        $user = User::where('staff_id',$staff->id)->first();

        if(!$user){
            return back()->with('error','No system access assigned');
        }

        // Generate token
        $token = Str::random(64);

        $user->update([
            'reset_token' => $token,
            'reset_token_expires_at' => Carbon::now()->addMinutes(30),
        ]);

        // Send email
        $resetLink = route('reset.password', ['token' => $token]);

        Mail::send('auth.emails.reset-password', [
            'name' => $staff->name,
            'resetLink' => $resetLink
        ], function ($message) use ($user, $staff) {
            $message->to($staff->email)
                    ->subject('UniManage — Password Reset Request');
        });

        return back()->with('success', 'A password reset link has been sent to your registered email.');
    }

    public function resetPassword($token)
    {
        $user = User::where('reset_token', $token)
                    ->where('reset_token_expires_at', '>', Carbon::now())
                    ->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'This reset link is invalid or has expired.');
        }

        return view('auth.reset-password', compact('token'));
    }

    public function resetPasswordProcess(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('reset_token', $request->token)
                    ->where('reset_token_expires_at', '>', Carbon::now())
                    ->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'This reset link is invalid or has expired.');
        }

        $user->update([
            'password'                => Hash::make($request->password),
            'reset_token'             => null,
            'reset_token_expires_at'  => null,
        ]);

        return redirect()->route('login')->with('success', 'Password reset successfully. Please sign in.');
    }

    public function changePassword()
    {
        return view('auth.change-password');
    }

    public function changePasswordProcess(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        // $user = Auth::user();
        // Fetch fresh user instance from DB instead of Auth::user()
        $user = User::find(Auth::id());

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        // Check new password is not same as current
        if (Hash::check($request->password, $user->password)) {
            return back()->with('error', 'New password must be different from current password.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        //Re-login the user to prevent session invalidation
        // Auth::login($user);
        // $request->session()->regenerate();

        //Logout and redirect to login
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return back()->with('success', 'Password changed successfully.');
    }

    

    
}
