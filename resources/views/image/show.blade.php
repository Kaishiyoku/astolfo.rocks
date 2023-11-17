<x-app-layout>
    <x-slot name="header">
        <x-page-header.container>
            <x-page-header.back-link :href="route('images.index')"/>
        </x-page-header.container>
    </x-slot>

    <x-card.card>
        <x-card.body>
            <div class="md:flex md:space-x-4">
                <a href="{{ $image->getUrl() }}" target="_blank" class="inline-block">
                    <img src="{{ $image->getUrl() }}" alt="{{ $image->id }}" class="max-w-[300px]"/>
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
                        @if ($image->source)
                            <x-link :href="$image->source">
                                {{ $image->source }}
                            </x-link>
                        @endif
                    </div>

                    <div>
                        {{ __('Created at') }}:
                        {{ formatDateTime($image->created_at) }}
                    </div>

                    <div>
                        {{ __('Updated at') }}:
                        {{ formatDateTime($image->updated_at) }}
                    </div>
                </div>
            </div>

            <div class="flex justify-between pt-4">
                <x-button :href="route('images.edit', $image)">
                    {{ __('Edit') }}
                </x-button>

                <x-delete-button :action="route('images.destroy', $image)"/>
            </div>
        </x-card.body>
    </x-card.card>
</x-app-layout>
