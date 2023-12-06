<div class="px-4 sm:px-0">
    <div class="text-lg pb-2">{{ $title }}</div>

    <div>
        <div>
            {{ __('ID') }}:
            {{ $image->id }}
        </div>

        <div>
            {{ __('Mime type') }}:
            {{ $image->mimetype }}
        </div>

        <div>
            {{ __('File size') }}:
            {{ Number::fileSize($image->file_size) }}
        </div>

        <div>
            {{ __('Image dimensions') }}:
            {{ $image->width }}x{{ $image->height }}
        </div>

        <div>
            <x-link :href="route('images.show', $image)">
                {{ __('Image details') }}
            </x-link>
        </div>
    </div>

    <div class="pt-4">
        <x-form-button :action="route('possible_duplicates.keep_image', [$possibleDuplicate, $image])" method="put">
            {{ __('Keep') }}
        </x-form-button>
    </div>

    <a href="{{ $image->getUrl() }}" target="_blank" class="inline-block pt-8">
        <img src="{{ $image->getUrl() }}" alt="{{ $image->id }}"/>
    </a>
</div>
