@if($model->hasMedia())
    <div>
        <div class="block font-medium text-sm text-gray-700 mb-1">Current image</div>
        <a href="{{ $model->getFirstMedia()->getFullUrl() }}" target="_blank">
            {{ $model->getFirstMedia()($previewName) }}
        </a>
        <x-inputs.label class="inline-flex items-center">
            <x-inputs.input type="checkbox" name="remove_image" value="1" />
            <span class="ml-2 text-red-800">Remove this image</span>
        </x-inputs.label>
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
