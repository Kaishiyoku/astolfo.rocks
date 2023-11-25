@props(['href', 'active' => false, 'badge' => null])

<a
    href="{{ $href }}"
    class="{{ classNames('inline-flex items-baseline px-3 py-0.5 rounded-lg transition', [
        'dark:text-gray-100 bg-white dark:bg-gray-500' => $active,
        'hover:bg-white/50 dark:hover:bg-gray-500/50' => !$active
    ]) }}"
>
    <span>{{ $slot }}</span>

    @if ($badge)
        <span
            class="{{ classNames('ml-2 text-xs', [
                'text-gray-500 dark:text-gray-300' => $active,
                'text-gray-500 dark:text-gray-400' => !$active,
            ]) }}"
        >
            {{ $badge }}
        </span>
    @endif
</a>
