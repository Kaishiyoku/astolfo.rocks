<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">
            {{ __('Possible duplicate') }}
        </h2>
    </x-slot>

    <x-form-button :action="route('possible_duplicates.ignore', [$possibleDuplicate])" method="put" class="pb-4">
        {{ __('Ignore') }}
    </x-form-button>

    <div class="flex">
        <div class="w-[49%] mr-[2%]">
            @include('possible_duplicate._image_details', ['title' => __('Left image'), 'possibleDuplicate' => $possibleDuplicate, 'image' => $possibleDuplicate->imageLeft])
        </div>

        <div class="w-[49%]">
            @include('possible_duplicate._image_details', ['title' => __('Right image'), 'possibleDuplicate' => $possibleDuplicate, 'image' => $possibleDuplicate->imageRight])
        </div>
    </div>
</x-app-layout>