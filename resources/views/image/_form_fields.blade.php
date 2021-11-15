<div class="mb-4">
    <x-label for="rating" :value="__('validation.attributes.rating')" required/>

    <x-select id="rating" class="block mt-1 w-full" name="rating" :value="old('rating', $image->rating)" :options="getAvailableImageRatingOptions()" required/>

    <x-validation-error for="rating"/>
</div>

<div class="mb-4">
    <x-label for="source" :value="__('validation.attributes.source')"/>

    <x-input id="source" class="block mt-1 w-full" type="text" name="source" :value="old('source', $image->source)"/>

    <x-validation-error for="source"/>
</div>

@if ($showFileInput)
    <div class="mb-4">
        <x-label for="image" :value="__('validation.attributes.image')" required/>

        <x-file-select-button id="image" name="image" class="mt-1 w-full" required/>

        <x-validation-error for="image"/>
    </div>
@endif