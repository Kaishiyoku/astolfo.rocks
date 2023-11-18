<x-app-layout>
    <div class="pb-8">
        <x-secondary-button :href="route('images.create')">{{ __('Add image') }}</x-secondary-button>
    </div>

    <div class="flex space-x-2 pb-8">
        @if (!request()->route()->parameter('rating'))
            <x-button :href="route('images.index')">
                <span>
                    {{ __('All') }}
                </span>

                <x-badge class="ml-2">
                    {{ $totalImageCount }}
                </x-badge>
            </x-button>
        @else
            <x-secondary-button :href="route('images.index')">
                <span>
                    {{ __('All') }}
                </span>

                <x-badge class="ml-2">
                    {{ $totalImageCount }}
                </x-badge>
            </x-secondary-button>
        @endif

        @foreach (\App\Enums\ImageRating::getValues() as $imageRating)
            @if (request()->route()->parameter('rating') === $imageRating)
                <x-button :href="route('images.index_by_rating', $imageRating)">
                    <span>{{ $imageRating }}</span>

                    <x-badge class="ml-2">
                        {{ $imagesByRatingCounts->get($imageRating) }}
                    </x-badge>
                </x-button>
            @else
                <x-secondary-button :href="route('images.index_by_rating', $imageRating)">
                    <span>{{ $imageRating }}</span>

                    <x-badge class="ml-2">
                        {{ $imagesByRatingCounts->get($imageRating) }}
                    </x-badge>
                </x-secondary-button>
            @endif
        @endforeach
    </div>

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
