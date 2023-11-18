@props(['active'])

<a {{ $attributes->merge(['class' => classNames(
    'px-2 py-0.5 text-sm dark:text-gray-200 hover:text-white rounded-md transition',
    [
        'text-gray-200 bg-fuchsia-700 hover:bg-fuchsia-600' => $active,
        'text-gray-600 hover:bg-gray-600' => !$active,
    ]
)]) }}>
    {{ $slot }}
</a>
