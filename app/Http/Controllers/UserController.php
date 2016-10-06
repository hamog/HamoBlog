<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Showing user profile form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProfile()
    {
        $user = Auth::user();
        return view('backend.user.profile', compact('user'));
    }

    /**
     * Update user profile.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'bail|required|email|max:255|unique:users,email,' . $user->id,
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        alert()->success('Success', 'Your profile was updated.');
        return back();
    }

    /**
     * Showing user change password form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPasswordForm()
    {
        return view('backend.user.password');
    }

    /**
     * Update user password.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password'  => 'required|min:6|max:17|exists:users,password',
            'password'      => 'required|min:6|max:17|confirmed'
        ]);
        $user = auth()->user();
        $user->password = $request->password;
        $user->save();
        alert()->success('Success', 'Your password is changed.');
        return back();
    }

    /**
     * Showing all users of blog.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allUsers()
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403);
        }
        $users = User::paginate(10);
        return view('backend.user.lists', compact('users'));
    }

    /**
     * Remove user.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyUser(User $user)
    {
        $user->delete();
        alert()->success('Success', 'The user removed.');
        return back();
    }
}
