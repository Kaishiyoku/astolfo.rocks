@props(['active'])

<a {{ $attributes->merge(['class' => classNames(
    'px-3 py-0.5 dark:text-gray-200 hover:text-white rounded-lg transition',
    [
        'text-gray-200 bg-fuchsia-600 dark:bg-fuchsia-700 hover:bg-fuchsia-500 dark:hover:bg-fuchsia-600' => $active,
        'text-gray-600 hover:bg-gray-600' => !$active,
    ]
)]) }}>
    {{ $slot }}
</a>
