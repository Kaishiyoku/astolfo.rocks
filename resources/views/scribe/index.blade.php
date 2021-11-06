<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Astolfo Rocks! Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=PT+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("vendor/scribe/css/theme-default.print.css") }}" media="print">
    <script src="{{ asset("vendor/scribe/js/theme-default-3.14.1.js") }}"></script>

    <link rel="stylesheet"
          href="//unpkg.com/@highlightjs/cdn-assets@10.7.2/styles/obsidian.min.css">
    <script src="//unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>


</head>

<body data-languages="[&quot;php&quot;,&quot;javascript&quot;]">
<a href="#" id="nav-button">
      <span>
        MENU
        <img src="{{ asset("vendor/scribe/images/navbar.png") }}" alt="navbar-image" />
      </span>
</a>
<div class="tocify-wrapper">
                <div class="lang-selector">
                            <a href="#" data-language-name="php">php</a>
                            <a href="#" data-language-name="javascript">javascript</a>
                    </div>
        <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>
    <ul class="search-results"></ul>

    <ul id="toc">
    </ul>

            <ul class="toc-footer" id="toc-footer">
                            <li><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                            <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
                    </ul>
            <ul class="toc-footer" id="last-updated">
            <li>Last updated: November 6 2021</li>
        </ul>
</div>
<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1>Introduction</h1>
<p>This documentation aims to provide all the information you need to work with our API.</p>
<aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).</aside>
<blockquote>
<p>Base URL</p>
</blockquote>
<pre><code class="language-yaml">http://localhost</code></pre>

        <h1>Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="endpoints">Endpoints</h1>

    

            <h2 id="endpoints-GETapi-v1-health_check">GET api/v1/health_check</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-health_check">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/health_check',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/health_check"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-v1-health_check">
    </span>
<span id="execution-results-GETapi-v1-health_check" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-health_check"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-health_check"></code></pre>
</span>
<span id="execution-error-GETapi-v1-health_check" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-health_check"></code></pre>
</span>
<form id="form-GETapi-v1-health_check" data-method="GET"
      data-path="api/v1/health_check"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-health_check', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/health_check</code></b>
        </p>
                    </form>

            <h2 id="endpoints-GETapi-v1-version">GET api/v1/version</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-version">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/version',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/version"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-v1-version">
    </span>
<span id="execution-results-GETapi-v1-version" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-version"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-version"></code></pre>
</span>
<span id="execution-error-GETapi-v1-version" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-version"></code></pre>
</span>
<form id="form-GETapi-v1-version" data-method="GET"
      data-path="api/v1/version"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-version', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/version</code></b>
        </p>
                    </form>

            <h2 id="endpoints-GETapi-v1-images-random--rating--">GET api/v1/images/random/{rating?}</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-images-random--rating--">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/images/random/consequatur',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/images/random/consequatur"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-v1-images-random--rating--">
    </span>
<span id="execution-results-GETapi-v1-images-random--rating--" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-images-random--rating--"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-images-random--rating--"></code></pre>
</span>
<span id="execution-error-GETapi-v1-images-random--rating--" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-images-random--rating--"></code></pre>
</span>
<form id="form-GETapi-v1-images-random--rating--" data-method="GET"
      data-path="api/v1/images/random/{rating?}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-images-random--rating--', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/images/random/{rating?}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>rating</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="rating"
               data-endpoint="GETapi-v1-images-random--rating--"
               value="consequatur"
               data-component="url" hidden>
    <br>

            </p>
                    </form>

            <h2 id="endpoints-GETapi-v1-images">GET api/v1/images</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-images">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/images',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/images"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-v1-images">
    </span>
<span id="execution-results-GETapi-v1-images" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-images"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-images"></code></pre>
</span>
<span id="execution-error-GETapi-v1-images" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-images"></code></pre>
</span>
<form id="form-GETapi-v1-images" data-method="GET"
      data-path="api/v1/images"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-images', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/images</code></b>
        </p>
                    </form>

            <h2 id="endpoints-GETapi-v1-images-rating--rating-">GET api/v1/images/rating/{rating}</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-images-rating--rating-">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/images/rating/consequatur',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/images/rating/consequatur"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-v1-images-rating--rating-">
    </span>
<span id="execution-results-GETapi-v1-images-rating--rating-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-images-rating--rating-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-images-rating--rating-"></code></pre>
</span>
<span id="execution-error-GETapi-v1-images-rating--rating-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-images-rating--rating-"></code></pre>
</span>
<form id="form-GETapi-v1-images-rating--rating-" data-method="GET"
      data-path="api/v1/images/rating/{rating}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-images-rating--rating-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/images/rating/{rating}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>rating</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="rating"
               data-endpoint="GETapi-v1-images-rating--rating-"
               value="consequatur"
               data-component="url" hidden>
    <br>

            </p>
                    </form>

            <h2 id="endpoints-GETapi-v1-images--id-">GET api/v1/images/{id}</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-images--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/images/17',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/images/17"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-v1-images--id-">
    </span>
<span id="execution-results-GETapi-v1-images--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-images--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-images--id-"></code></pre>
</span>
<span id="execution-error-GETapi-v1-images--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-images--id-"></code></pre>
</span>
<form id="form-GETapi-v1-images--id-" data-method="GET"
      data-path="api/v1/images/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-images--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/images/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="GETapi-v1-images--id-"
               value="17"
               data-component="url" hidden>
    <br>
<p>The ID of the image.</p>
            </p>
                    </form>

            <h2 id="endpoints-GETapi-v1-tags">GET api/v1/tags</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-tags">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/tags',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/tags"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-v1-tags">
    </span>
<span id="execution-results-GETapi-v1-tags" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-tags"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-tags"></code></pre>
</span>
<span id="execution-error-GETapi-v1-tags" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-tags"></code></pre>
</span>
<form id="form-GETapi-v1-tags" data-method="GET"
      data-path="api/v1/tags"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-tags', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/tags</code></b>
        </p>
                    </form>

            <h2 id="endpoints-GETapi-v1-tags--id-">GET api/v1/tags/{id}</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-tags--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/tags/17',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/tags/17"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-v1-tags--id-">
    </span>
<span id="execution-results-GETapi-v1-tags--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-tags--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-tags--id-"></code></pre>
</span>
<span id="execution-error-GETapi-v1-tags--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-tags--id-"></code></pre>
</span>
<form id="form-GETapi-v1-tags--id-" data-method="GET"
      data-path="api/v1/tags/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-tags--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/tags/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="GETapi-v1-tags--id-"
               value="17"
               data-component="url" hidden>
    <br>
<p>The ID of the tag.</p>
            </p>
                    </form>

            <h2 id="endpoints-GETapi-v1-stats">GET api/v1/stats</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-stats">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/stats',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/stats"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-v1-stats">
    </span>
<span id="execution-results-GETapi-v1-stats" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-stats"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-stats"></code></pre>
</span>
<span id="execution-error-GETapi-v1-stats" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-stats"></code></pre>
</span>
<form id="form-GETapi-v1-stats" data-method="GET"
      data-path="api/v1/stats"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-stats', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/stats</code></b>
        </p>
                    </form>

            <h2 id="endpoints-GETapi--fallbackPlaceholder-">GET api/{fallbackPlaceholder}</h2>

<p>
</p>



<span id="example-requests-GETapi--fallbackPlaceholder-">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/2UZ5i',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/2UZ5i"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi--fallbackPlaceholder-">
    </span>
<span id="execution-results-GETapi--fallbackPlaceholder-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi--fallbackPlaceholder-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi--fallbackPlaceholder-"></code></pre>
</span>
<span id="execution-error-GETapi--fallbackPlaceholder-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi--fallbackPlaceholder-"></code></pre>
</span>
<form id="form-GETapi--fallbackPlaceholder-" data-method="GET"
      data-path="api/{fallbackPlaceholder}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi--fallbackPlaceholder-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/{fallbackPlaceholder}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>fallbackPlaceholder</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="fallbackPlaceholder"
               data-endpoint="GETapi--fallbackPlaceholder-"
               value="2UZ5i"
               data-component="url" hidden>
    <br>

            </p>
                    </form>

    

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                    <a href="#" data-language-name="php">php</a>
                                    <a href="#" data-language-name="javascript">javascript</a>
                            </div>
            </div>
</div>
<script>
    $(function () {
        var exampleLanguages = ["php","javascript"];
        setupLanguages(exampleLanguages);
    });
</script>
</body>
</html>