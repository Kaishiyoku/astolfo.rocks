@extends('app')

@section('content')
    <div class="md:flex md:justify-between">
        <div>
            <p class="pt-1 pb-2">
                <img src="{{ asset('img/astolfo.png') }}" class="max-h-400" alt="Astolfo"/>
            </p>

            <p class="pt-1 pb-2">
                @foreach (getSocialMediaLinks() as $link)
                    <a href="{{ $link['url'] }}" class="inline-block py-2 px-3 border border-gray-800 text-black rounded no-underline mr-1 hover:transition-all hover:duration-200 hover:text-white hover:bg-gray-800 hover:no-underline focus:outline-none focus:ring-4 focus:ring-gray-300 transition-all duration-200">{{ $link['title'] }}</a>
                @endforeach
            </p>
        </div>

        <div>
            <div class="text-xl pt-8 pb-2">Random Astolfo</div>

            <a href="{{ env('CRAWLER_BASE_URL') }}/post/view/{{ $randomImage->external_id }}" class="block">
                <img src="{{ url('/api/v1/images/' . $randomImage->external_id . '/data') }}" class="rounded border-2 border-pink-200 opacity-50 p-2 hover:opacity-100 max-h-400 transition-all duration-300" alt="random Astolfo image"/>
            </a>
        </div>
    </div>
@endsection
