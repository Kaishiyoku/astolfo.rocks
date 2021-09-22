@extends('app')

@section('content')
    <div class="md:flex md:justify-between">
        <div>
            <p class="pt-1 pb-2">
                <img src="{{ asset('img/astolfo.png') }}" class="max-h-400" alt="Astolfo"/>
            </p>

            <p class="pt-1 pb-2">
                @foreach (getSocialMediaLinks() as $link)
                    <x-button-link :url="$link['url']">
                        {{ $link['title'] }}
                    </x-button-link>
                @endforeach
            </p>
        </div>

        <div>
            <div class="text-xl pt-8 pb-2">Random Astolfo</div>

            <a href="{{ config('astolfo.crawler_base_url') }}/post/view/{{ $randomImage->external_id }}" class="block">
                <img src="{{ asset($randomImage->getFilePath()) }}" class="rounded border-2 border-pink-200 opacity-50 p-2 hover:opacity-100 max-h-400 transition-all duration-300" alt="random Astolfo image"/>
            </a>
        </div>
    </div>
@endsection
