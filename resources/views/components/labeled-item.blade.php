@props(['label', 'description'])

<div class="pb-2">
    <div class="text-sm text-muted">{{ $label }}</div>

    <div>{{ $slot->isNotEmpty() ? $slot : $description }}</div>
</div>
