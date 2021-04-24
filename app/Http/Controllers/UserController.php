<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\UpdatesUser;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    use UpdatesUser;

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('users.index')->with('users', User::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        return $this->edit(new User());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateUserRequest $request): RedirectResponse
    {
        return $this->update($request, new User());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('users.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->updateUser($request, $user);
        session()->flash('message', "User {$user->name} updated!");
        return redirect()->route('users.index');
    }

    /**
     * Confirm removal of specified resource.
     */
    public function delete(User $user): View
    {
        $this->authorize('delete', $user);
        return view('users.delete')->with('user', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);
        $user->delete();
        return redirect(route('users.index'))
            ->with('message', "User {$user->name} deleted!");
    }
}
