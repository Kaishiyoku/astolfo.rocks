@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center space-x-1 px-3 py-0.5 rounded-full border border-gray-200 dark:border-gray-800 text-gray-500 hover:text-gray-700 dark:hover:text-gray-400 focus:border-gray-400 transition']) }}>
    {{ $slot }}
</a>
