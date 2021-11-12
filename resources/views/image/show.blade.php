<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">
            {{ __('Image details') }}
        </h2>
    </x-slot>

    <x-card.card>
        <x-card.body>
            <div class="md:flex md:space-x-4">
                <a href="/{{ $image->getFilePath() }}" target="_blank" class="inline-block">
                    <img src="/{{ $image->getFilePath() }}" alt="{{ $image->id }}" class="max-w-[300px]"/>
                </a>

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

                    <div>
                        {{ __('Rating') }}:
                        {{ $image->rating }}
                    </div>

                    <div>
                        {{ __('Views') }}:
                        {{ $image->views }}
                    </div>

                    <div>
                        {{ __('Source') }}:
                        {{ $image->source }}
                    </div>

                    <div>
                        {{ __('Created at') }}:
                        {{ formatDateTime($image->created_at) }}
                    </div>

                    <div>
                        {{ __('Updated at') }}:
                        {{ formatDateTime($image->updated_at) }}
                    </div>

                    <div class="pt-4 md:pt-0">
                        <div class="pb-2">{{ __('Identifier image') }}:</div>
                        <img src="data:{{ $image->mimetype }};base64,{{ base64_encode($image->identifier_image) }}" alt="Identifier image" class="w-[150px] h-[150px] image-rendering-none"/>
                    </div>
                </div>
            </div>
        </x-card.body>
    </x-card.card>
</x-app-layout>