@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 dark:border-gray-700 focus:border-pink-300 dark:bg-gray-900 focus:ring focus:ring-pink-200 focus:ring-opacity-50']) !!}>
