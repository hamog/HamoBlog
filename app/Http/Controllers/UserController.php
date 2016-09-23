<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        return view('backend.user.profile', compact('user'));
    }

    public function updateProfile(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'bail|required|email|max:255|unique:users,email,' . $user->id,
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return back()->with('success', 'Profile Updated!');
    }
}
