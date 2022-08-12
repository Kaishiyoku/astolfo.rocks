@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'text-pink-600 dark:text-pink-400 hover:text-pink-700 dark:hover:text-pink-300 hover:underline']) }}>
    {{ $slot }}
</a>
