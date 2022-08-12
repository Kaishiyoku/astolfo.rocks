<x-app-layout>
    <x-slot name="header">
        <x-page-header.headline>
            {{ __('Dashboard') }}
        </x-page-header.headline>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    You're logged in!
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
