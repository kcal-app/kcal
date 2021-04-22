<div class="flex-auto space-y-1">
    <x-inputs.label for="password" value="Password"/>

    <x-inputs.input name="password"
                    type="password"
                    class="block w-full"
                    :hasError="$errors->has('password')"
                    :required="!$user->exists"/>
</div>
<div class="flex-auto space-y-1">
    <x-inputs.label for="password_confirmation" value="Confirm Password"/>

    <x-inputs.input name="password_confirmation"
                    type="password"
                    class="block w-full"
                    :hasError="$errors->has('password')"
                    :required="!$user->exists"/>
</div>
