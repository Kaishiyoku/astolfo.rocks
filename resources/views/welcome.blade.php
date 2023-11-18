<x-guest-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="md:flex md:justify-between">
            <div>
                <div class="pt-1 pb-2">
                    <img src="{{ asset('img/astolfo.png') }}" class="max-h-[400px]" alt="Astolfo"/>
                </div>

                <div class="sm:flex py-4">
                    @foreach (getSocialMediaLinks() as $link)
                        <x-icon-link :href="$link['url']" class="sm:mr-2 mb-2 w-full sm:w-auto">
                            {{ $link['title'] }}
                        </x-icon-link>
                    @endforeach
                </div>
            </div>

            <div>
                <div class="text-xl pt-8 pb-2">{{ __('Random Astolfo') }}</div>

                <a href="{{ $randomImage->getUrl() }}" class="block">
                    <img src="{{ $randomImage->getThumbnailUrl() }}" class="opacity-50 hover:opacity-100 max-h-[400px] rounded-lg shadow-md dark:shadow-black/25 transition duration-300" alt="{{ __('random Astolfo image') }}"/>
                </a>
            </div>
        </div>

        <div class="pt-12 text-sm text-gray-500">
            <div>
                {{ __('Astolfo render by') }} <x-link href="https://ino2206.deviantart.com">Ino2206</x-link>
            </div>

            <div>
                @auth
                    <x-link href="{{ route('dashboard') }}">{{ __('Dashboard') }}</x-link>
                @else
                    <x-link href="{{ route('login') }}">{{ __('Login') }}</x-link>
                @endauth
            </div>
        </div>
    </div>
</x-guest-layout>
