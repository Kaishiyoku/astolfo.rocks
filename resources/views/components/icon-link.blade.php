@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center space-x-1 px-2 py-0.5 rounded-full text-gray-500 hover:text-gray-700 focus:ring focus:ring-1 focus:ring-gray-400 transition']) }}>
    {{ $slot }}
</a>
