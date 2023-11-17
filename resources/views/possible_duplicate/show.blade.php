<x-app-layout>
    <x-slot name="header">
        <x-page-header.container>
            <x-page-header.back-link :href="route('possible_duplicates.index')"/>
        </x-page-header.container>
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
