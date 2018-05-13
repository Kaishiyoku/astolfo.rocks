<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }}</title>

    {!! Html::style('css/app.css') !!}

    {!! Html::script('js/app.js') !!}
</head>
<body>

<div class="credits">
    Astolfo render by <a href="https://ino2206.deviantart.com">Ino2206</a>
</div>

<div class="custom-container">
    <p>
        Welcome to my page! ^__^
    </p>

    <p>
        <a href="https://mangas.astolfo.rocks" class="lg">Manga list</a>
    </p>
</div>

</body>
</html>
