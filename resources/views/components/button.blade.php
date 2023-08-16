<?php
    $component = isset($href) ? 'a' : 'button';
?>

<{{ $component }} {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 border border-gray-800 rounded-full text-sm text-white tracking-widest hover:text-gray-900 hover:bg-white focus:text-gray-900 focus:bg-white focus:outline-none focus:border-gray-900 focus:ring-1 ring-gray-800 disabled:opacity-25 shadow transition-all']) }}>
    {{ $slot }}
</{{ $component }}>
