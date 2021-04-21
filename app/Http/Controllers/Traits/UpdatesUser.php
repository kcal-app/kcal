<?php

namespace App\Http\Controllers\Traits;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait UpdatesUser
{

    /**
     * Updates a user from a user update request.
     */
    public function updateUser(UpdateUserRequest $request, User $user): void {
        $input = $request->validated();
        $input['remember_token'] = Str::random(10);
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        }
        else {
            unset($input['password']);
        }
        $input['admin'] = $input['admin'] ?? false;

        $user->fill($input)->save();

        // Handle image.
        if (!empty($input['image'])) {
            /** @var \Illuminate\Http\UploadedFile $file */
            $file = $input['image'];
            $user->clearMediaCollection();
            $user
                ->addMediaFromRequest('image')
                ->usingName($user->username)
                ->usingFileName("{$user->slug}.{$file->extension()}")
                ->toMediaCollection();
        }
        elseif (isset($input['remove_image']) && $input['remove_image']) {
            $user->clearMediaCollection();
        }
    }

}
