@props(['href', 'active' => false, 'badge' => null])

<a
    href="{{ $href }}"
    class="{{ classNames('inline-flex items-baseline px-3 py-0.5 rounded-lg transition', [
        'bg-white' => $active,
        'hover:bg-white/50' => !$active
    ]) }}"
>
    <span>{{ $slot }}</span>

    @if ($badge)
        <span class="ml-2 text-xs text-muted">
            {{ $badge }}
        </span>
    @endif
</a>
