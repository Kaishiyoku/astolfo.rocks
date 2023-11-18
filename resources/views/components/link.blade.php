@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'text-gray-600 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 underline transition']) }}>
    {{ $slot }}
</a>
