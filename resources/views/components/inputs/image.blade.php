@if($model->hasMedia())
    <div>
        <div class="block font-medium text-sm text-gray-700 mb-1">Current image</div>
        <a href="{{ $model->getFirstMedia()->getFullUrl() }}" target="_blank">
            {{ $model->getFirstMedia()($previewName) }}
        </a>
        <fieldset class="flex space-x-2 mt-1 items-center">
            <x-inputs.label for="remove_image" class="text-red-800" value="Remove this image" />
            <x-inputs.input type="checkbox" name="remove_image" value="1" />
        </fieldset>
    </div>
@endif
<div>
    @if($model->hasMedia())
        <x-inputs.label for="image" value="Replace image" />
    @else
        <x-inputs.label for="image" value="Add image" />
    @endif

    <x-inputs.file name="image"
                   class="block mt-1 w-full"
                   accept="image/png, image/jpeg"/>
</div>
