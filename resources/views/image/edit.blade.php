<x-app-layout>
    <x-slot name="header">
        <x-page-header.container>
            {{ __('Edit image') }} #{{ $image->id }}
        </x-page-header.container>
    </x-slot>

    <div class="pb-8">
        <a href="{{ $image->getUrl() }}" target="_blank" class="inline-block">
            <img src="{{ $image->getUrl() }}" alt="{{ $image->id }}" class="max-w-[300px]"/>
        </a>
    </div>

    {{ html()->modelForm($image, 'put', route('images.update', $image))->class('px-4 sm:px-0')->acceptsFiles()->open() }}
        @include('image._form_fields')

        <x-button>{{ __('Save') }}</x-button>
    {{ html()->closeModelForm() }}
</x-app-layout>
