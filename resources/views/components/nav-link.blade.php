@props(['active'])

<a {{ $attributes->merge(['class' => classNames('px-2 py-0.5 text-sm text-gray-200 hover:text-white hover:bg-gray-600 rounded-md transition', ['bg-fuchsia-700 hover:bg-fuchsia-600' => $active])]) }}>
    {{ $slot }}
</a>
