<div class="px-4 sm:px-0">
    <div class="text-lg pb-2">{{ $title }}</div>

    <div class="md:flex md:justify-between md:items-start md:space-x-4">
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
                {{ formatFileSize($image->file_size) }}
            </div>

            <div>
                {{ __('Image dimensions') }}:
                {{ $image->width }}x{{ $image->height }}
            </div>
        </div>

        <div class="pt-4 md:pt-0">
            <div class="pb-2">{{ __('Identifier image') }}:</div>
            <img src="data:{{ $image->mimetype }};base64,{{ base64_encode($image->identifier_image) }}" alt="Identifier image" class="w-[150px] h-[150px] image-rendering-none"/>
        </div>
    </div>

    <div class="pt-4">
        <x-form-button :action="route('possible_duplicates.keep_image', [$possibleDuplicate, $image])" method="put">
            {{ __('Keep') }}
        </x-form-button>
    </div>

    <a href="/{{ $image->getFilePath() }}" target="_blank" class="inline-block pt-8">
        <img src="/{{ $image->getFilePath() }}" alt="{{ $image->id }}"/>
    </a>
</div>