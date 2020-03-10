@extends('app')

@section('content')
    <div class="container pt-4">
        <div class="row pb-5">
            <div class="col-sm-6">
                <p>
                    <img src="img/astolfo.png" class="img-fluid" style="max-height: 400px"/>
                </p>

                <p>
                    @foreach (getSocialMediaLinks() as $link)
                        {{ Html::link($link['url'], $link['title'], ['class' => 'btn btn-outline-dark']) }}
                    @endforeach
                </p>
            </div>

            <div class="col-sm-6">
                <h2 class="mt-5">Random Astolfo</h2>

                <a href="{{ env('CRAWLER_BASE_URL') }}/post/view/{{ $randomImage->external_id }}">
                    <img src="{{ $randomImage->url }}" class="img-fluid img-thumbnail" style="max-height: 400px;"/>
                </a>
            </div>
        </div>
    </div>
@endsection
