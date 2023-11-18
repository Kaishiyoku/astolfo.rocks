<x-app-layout>
    <x-slot name="header">
        {{ __('Add image') }}
    </x-slot>

    {{ html()->modelForm($image, 'post', route('images.store'))->class('px-4 sm:px-0')->acceptsFiles()->open() }}
        @include('image._form_fields')

        <x-button>{{ __('Save') }}</x-button>
    {{ html()->closeModelForm() }}
</x-app-layout>
