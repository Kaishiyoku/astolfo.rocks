<div class="mb-4">
    <x-label for="rating" :value="__('validation.attributes.rating')" required/>

    <x-select id="rating" class="block mt-1 w-full" name="rating" :value="old('rating', $image->rating?->value)" :options="getAvailableImageRatingOptions()" required/>

    <x-validation-error for="rating"/>
</div>

<div class="mb-4">
    <x-label for="source" :value="__('validation.attributes.source')"/>

    <x-input id="source" class="block mt-1 w-full" type="text" name="source" :value="old('source', $image->source)"/>

    <x-validation-error for="source"/>
</div>

<div class="mb-4">
    <x-label for="image" :value="__('validation.attributes.image')" :required="!$image->exists"/>

    <x-file-select-button id="image" name="image" class="mt-1 w-full" :required="!$image->exists"/>

    <x-validation-error for="image"/>
</div>
