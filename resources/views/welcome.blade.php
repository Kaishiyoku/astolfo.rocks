@extends('app')

@section('content')
    <div class="credits">
        Astolfo render by <a href="https://ino2206.deviantart.com">Ino2206</a>
    </div>

    <div class="container">
        <div class="row pb-5">
            <div class="col-sm-6 order-1 order-sm-0">
                <h1>Welcome ^__^</h1>
            </div>

            <div class="col-sm-6 order-0 order-sm-1 text-center pb-3">
                <img src="img/astolfo.png" class="img-fluid" style="max-height: 400px"/>
            </div>
        </div>

        <p>
            <a href="https://mangas.astolfo.rocks" class="btn btn-dark btn-lg">Manga list</a>
        </p>

        <h2>Links</h2>

        @foreach (getSocialMediaLinks() as $link)
            {{ Html::link($link['url'], $link['title'], ['class' => 'btn btn-outline-light']) }}
        @endforeach

        <h2 class="mt-5">Random Astolfo</h2>

        <a href="{{ env('CRAWLER_BASE_URL') }}/post/view/{{ $randomImage->external_id }}">
            <img src="{{ $randomImage->url }}" class="img-fluid img-thumbnail" style="max-height: 400px;"/>
        </a>
    </div>
@endsection