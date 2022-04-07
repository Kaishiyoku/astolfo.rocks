@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'p-2 rounded-full text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition']) }}>
    {{ $slot }}
</a>