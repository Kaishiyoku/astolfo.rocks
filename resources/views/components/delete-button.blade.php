@props(['action'])

<form class="inline-block" method="post" action="{{ $action }}">
    @csrf

    <input type="hidden" name="_method" value="delete"/>

    <button type="submit" data-confirm="{{ __('Are you sure?') }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-full text-sm text-white tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition']) }}>
        @if ($slot->isEmpty())
            {{ __('Delete') }}
        @else
            {{ $slot }}
        @endif
    </button>
</form>
