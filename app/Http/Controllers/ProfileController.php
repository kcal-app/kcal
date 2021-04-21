<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\UpdatesUser;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    use UpdatesUser;

    /**
     * Display a user profile page.
     */
    public function show(User $user): View
    {
        return view('profiles.show')->with('user', $user);
    }

    /**
     * Show the form for editing a user's profile data.
     */
    public function edit(User $user): View
    {
        return view('profiles.edit')->with('user', $user);
    }

    /**
     * Update the user profile data.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->updateUser($request, $user);
        $user->refresh();
        session()->flash('message', "Profile updated!");
        return redirect()->route('profiles.show', $user);
    }

}
