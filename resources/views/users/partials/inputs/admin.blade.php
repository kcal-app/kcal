<div class="space-y-1">
    <x-inputs.label for="admin" value="Site Admin" class="inline-block"/>

    <x-inputs.select name="admin"
                     class="block"
                     :options="[['value' => 0, 'label' => 'No'], ['value' => 1, 'label' => 'Yes']]"
                     :selectedValue="old('admin', $user->admin)">
    </x-inputs.select>
</div>
