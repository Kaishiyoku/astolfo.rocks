<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">
            {{ __('Images') }}
        </h2>

        <div>{{ trans_choice('image.total_number_of_images', $totalImageCount) }}</div>
    </x-slot>

    <div class="flex space-x-2 pb-8">
        <x-button-link :href="route('images.index')" class="{{ classNames(['text-pink-300 bg-pink-800 hover:bg-pink-900' => !request()->route()->parameter('rating')]) }}">
            {{ __('All') }}
        </x-button-link>

        @foreach (\App\Enums\ImageRating::getValues() as $imageRating)
            <x-button-link :href="route('images.index', $imageRating)" class="{{ classNames(['text-pink-300 bg-pink-800 hover:bg-pink-900' => request()->route()->parameter('rating') === $imageRating]) }}">
                {{ $imageRating }}
            </x-button-link>
        @endforeach
    </div>

    @if ($images->isNotEmpty())
        <div class="grid sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @foreach ($images as $image)
                <a href="{{ route('images.show', $image) }}" class="group block transition sm:rounded-lg hover:opacity-70">
                    <x-card.card class="h-full overflow-hidden">
                        <div class="pb-2">
                            <img src="/{{ $image->getFilePath() }}" alt="{{ $image->id }}" height="{{ $image->height }}" class="h-full object-cover transform group-hover:scale-110 transition ease-in-out" loading="lazy"/>
                        </div>

                        <x-card.body>
                            {{ $image->rating }}
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