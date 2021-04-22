<div class="flex-auto space-y-1">
    <x-inputs.label for="name" value="Display name"/>

    <x-inputs.input name="name"
                    type="text"
                    class="block w-full"
                    :value="old('name', $user->name)"
                    :hasError="$errors->has('name')"
                    required />
</div>
