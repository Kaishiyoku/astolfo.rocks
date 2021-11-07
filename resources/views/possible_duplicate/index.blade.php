<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">
            {{ __('Possible duplicates') }}
        </h2>
    </x-slot>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($possibleDuplicates as $possibleDuplicate)
            <a href="{{ route('possible_duplicates.show', $possibleDuplicate) }}" class="block transition sm:rounded-lg bg-white hover:bg-gray-50 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                <x-card.card class="h-full bg-transparent">
                    <x-card.body class="flex h-full">
                        <img src="/{{ $possibleDuplicate->imageLeft->getFilePath() }}" alt="{{ $possibleDuplicate->imageLeft->id }}" class="max-w-[49%] h-full object-cover mr-[2%]"/>
                        <img src="/{{ $possibleDuplicate->imageRight->getFilePath() }}" alt="{{ $possibleDuplicate->imageRight->id }}" class="max-w-[49%] h-full object-cover"/>
                    </x-card.body>
                </x-card.card>
            </a>
        @endforeach
    </div>

    <div class="px-4 sm:px-0 pt-8">
        {{ $possibleDuplicates->links() }}
    </div>
</x-app-layout>