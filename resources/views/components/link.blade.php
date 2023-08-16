@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'text-fuchsia-600 dark:text-fuchsia-400 hover:text-fuchsia-700 dark:hover:text-fuchsia-300 hover:underline']) }}>
    {{ $slot }}
</a>
