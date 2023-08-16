<?php
$component = isset($href) ? 'a' : 'button';
?>

<{{ $component }} {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-white border border-gray-500 rounded-full text-sm text-gray-900 tracking-widest hover:text-white hover:bg-gray-800 focus:text-white focus:bg-gray-800 focus:outline-none focus:border-gray-900 focus:ring-1 ring-gray-800 disabled:opacity-25 shadow transition-all']) }}>
    {{ $slot }}
</{{ $component }}>
