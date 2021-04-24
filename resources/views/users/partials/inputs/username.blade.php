<div class="flex-auto space-y-1">
    <x-inputs.label for="username" value="Username"/>

    <x-inputs.input name="username"
                    type="text"
                    class="block w-full"
                    autocapitalize="none"
                    :value="old('username', $user->username)"
                    :hasError="$errors->has('username')"
                    required />
</div>
