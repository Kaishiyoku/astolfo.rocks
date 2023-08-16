@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-lg shadow border-gray-300 dark:border-gray-700 focus:border-gray-600 dark:bg-gray-900 focus:ring-1 focus:ring-gray-600 transition']) !!}/>
