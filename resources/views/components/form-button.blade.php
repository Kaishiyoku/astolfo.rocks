@props(['action', 'method'])

<form method="post" action="{{ $action }}" {{ $attributes->merge(['class' => 'inline-block']) }}>
    @csrf

    <input type="hidden" name="_method" value="{{ $method }}"/>

    <x-button data-confirm="{{ __('Are you sure?') }}">
        {{ $slot }}
    </x-button>
</form>