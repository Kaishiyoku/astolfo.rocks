<p>The crawler test failed.</p>

<p>Collected:</p>

<ul>
    @foreach ($collectedFields as $collectedField)
        <li>{{ $collectedField }}</li>
    @endforeach
</ul>

<p>Expected:</p>

<ul>
    @foreach ($expectedFields as $expectedField)
        <li>{{ $expectedField }}</li>
    @endforeach
</ul>