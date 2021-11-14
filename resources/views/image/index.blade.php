<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">
            {{ __('Images') }}
        </h2>

        <div>{{ trans_choice('image.total_number_of_images', $images->total()) }}</div>
    </x-slot>

    <div class="grid sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
        @foreach ($images as $image)
            <a href="{{ route('images.show', $image) }}" class="block transition sm:rounded-lg hover:opacity-70">
                <x-card.card class="h-full overflow-hidden">
                    <img src="/{{ $image->getFilePath() }}" alt="{{ $image->id }}" height="{{ $image->height }}" class="h-full object-cover transform hover:scale-110 transition ease-in-out" loading="lazy"/>
                </x-card.card>
            </a>
        @endforeach
    </div>

    <div class="px-4 sm:px-0 pt-8">
        {{ $images->links() }}
    </div>
</x-app-layout>