@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'text-pink-600 hover:text-pink-700 hover:underline']) }}>
    {{ $slot }}
</a>