<x-app-layout>
    <x-slot:header>
        <x-icon-link :href="route('images.create')">
            <x-heroicon-o-plus/>

            <span>{{ __('Add image') }}</span>
        </x-icon-link>
    </x-slot:header>

    <x-tabs.bar class="mb-8">
        <x-tabs.link :href="route('images.index')" :active="!request()->route()->parameter('rating')">
            {{ __('All') }}

            <x-slot:badge>
                {{ $totalImageCount }}
            </x-slot:badge>
        </x-tabs.link>

        @foreach (\App\Enums\ImageRating::getValues() as $imageRating)
            <x-tabs.link :href="route('images.index_by_rating', $imageRating)" :active="request()->route()->parameter('rating') === $imageRating">
                {{ Str::ucfirst($imageRating) }}

                <x-slot:badge>
                    {{ $imagesByRatingCounts->get($imageRating) }}
                </x-slot:badge>
            </x-tabs.link>
        @endforeach
    </x-tabs.bar>

    @if ($images->isNotEmpty())
        <div class="grid sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @foreach ($images as $image)
                <a href="{{ route('images.show', $image) }}" class="group block w-full h-[250px] transition sm:rounded-lg hover:opacity-70">
                    <x-card.card class="h-full overflow-hidden bg-cover transform hover:scale-105 transition ease-in-out" style="background-image: url('{{ $image->getThumbnailUrl() }}')">
                        <x-card.body class="absolute bottom-0">
                            <x-badge>
                                {{ $image->rating }}
                            </x-badge>
                        </x-card.body>
                    </x-card.card>
                </a>
            @endforeach
        </div>
    @else
        <x-empty-info>
            {{ __('No images found.') }}
        </x-empty-info>
    @endif

    <div class="px-4 sm:px-0 pt-8">
        {{ $images->links() }}
    </div>
</x-app-layout>
