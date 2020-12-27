@extends('app')

@section('content')
    <div class="md:flex md:justify-between">
        <div>
            <p>
                <img src="{{ asset('img/astolfo.png') }}" class="img-fluid" alt="Astolfo"/>
            </p>

            <p>
                @foreach (getSocialMediaLinks() as $link)
                    <a href="{{ $link['url'] }}" class="btn">{{ $link['title'] }}</a>
                @endforeach
            </p>
        </div>

        <div>
            <div class="text-xl pt-8 pb-2">Random Astolfo</div>

            <a href="{{ env('CRAWLER_BASE_URL') }}/post/view/{{ $randomImage->external_id }}">
                <img src="{{ url('/api/v1/images/' . $randomImage->external_id . '/data') }}" class="img-fluid border border-pink-400 rounded p-1 bg-white" alt="random Astolfo image"/>
            </a>
        </div>
    </div>
@endsection
