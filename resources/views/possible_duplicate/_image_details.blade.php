<div class="px-4 sm:px-0">
    <div class="text-lg pb-2">{{ $title }}</div>

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
        {{ formatFileSize($image->file_size) }}
    </div>

    <div>
        {{ __('Image dimensions') }}:
        {{ $image->width }}x{{ $image->height }}
    </div>

    <div class="pt-2">
        <x-form-button :action="route('possible_duplicates.keep_image', [$possibleDuplicate, $image])" method="put">
            {{ __('Keep') }}
        </x-form-button>
    </div>

    <a href="/{{ $image->getFilePath() }}" target="_blank" class="inline-block pt-8">
        <img src="/{{ $image->getFilePath() }}" alt="{{ $image->id }}"/>
    </a>
</div>