<x-app-layout>
    <x-slot name="header">
        <x-page-header.back-link :href="route('images.index')"/>
    </x-slot>

    <x-card.card>
        <x-card.body>
            <div class="md:flex md:space-x-4">
                <a href="{{ $image->getUrl() }}" target="_blank" class="inline-block">
                    <img src="{{ $image->getUrl() }}" alt="{{ $image->id }}" class="max-w-[300px]"/>
                </a>

                <div>
                    <x-labeled-item :label="__('ID')" :description="$image->id"/>

                    <x-labeled-item :label="__('Rating')" :description="$image->rating"/>

                    <x-labeled-item :label="__('Image dimensions')" :description="$image->width . 'x' . $image->height"/>

                    <x-labeled-item :label="__('Mime type')" :description="$image->mimetype"/>

                    <x-labeled-item :label="__('File size')" :description="Number::fileSize($image->file_size)"/>

                    <x-labeled-item :label="__('Views')" :description="$image->views"/>

                    <x-labeled-item :label="__('Source')">
                        @if ($image->source)
                            <x-link :href="$image->source">
                                {{ $image->source }}
                            </x-link>
                        @else
                            /
                        @endif
                    </x-labeled-item>

                    <x-labeled-item :label="__('Created at')" :description="formatDateTime($image->created_at)"/>

                    <x-labeled-item :label="__('Updated at')" :description="formatDateTime($image->updated_at)"/>
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
