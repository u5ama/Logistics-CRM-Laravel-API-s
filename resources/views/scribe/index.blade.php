<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>StartBuck</title>

    <link href="https://fonts.googleapis.com/css?family=PT+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .javascript-example code { display: none; }
                    body .content .php-example code { display: none; }
            </style>

    <script>
        var baseUrl = "http://localhost";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-4.0.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-4.0.0.js") }}"></script>

</head>

<body data-languages="[&quot;javascript&quot;,&quot;php&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image" />
    </span>
</a>
<div class="tocify-wrapper">
            <img src="../assets/images/Starbuck-White.png" alt="logo" class="logo" style="padding-top: 10px;" width="100%"/>
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                                            <button type="button" class="lang-button" data-language-name="php">php</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-login">
                                <a href="#endpoints-POSTapi-v1-login">POST api/v1/login</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-register">
                                <a href="#endpoints-POSTapi-v1-register">POST api/v1/register</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-sendPasswordResetLink">
                                <a href="#endpoints-POSTapi-v1-sendPasswordResetLink">POST api/v1/sendPasswordResetLink</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-resetPassword">
                                <a href="#endpoints-POSTapi-v1-resetPassword">POST api/v1/resetPassword</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-superAdmin-users">
                                <a href="#endpoints-GETapi-v1-superAdmin-users">Show the application dashboard.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-superAdmin-users">
                                <a href="#endpoints-POSTapi-v1-superAdmin-users">POST api/v1/superAdmin/users</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-superAdmin-userShow">
                                <a href="#endpoints-POSTapi-v1-superAdmin-userShow">Show the profile for a given user.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-superAdmin-users--id-">
                                <a href="#endpoints-POSTapi-v1-superAdmin-users--id-">POST api/v1/superAdmin/users/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-v1-superAdmin-users--id-">
                                <a href="#endpoints-DELETEapi-v1-superAdmin-users--id-">DELETE api/v1/superAdmin/users/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-superAdmin-changeStatus--id-">
                                <a href="#endpoints-POSTapi-v1-superAdmin-changeStatus--id-">POST api/v1/superAdmin/changeStatus/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-superAdmin-userRoles">
                                <a href="#endpoints-GETapi-v1-superAdmin-userRoles">GET api/v1/superAdmin/userRoles</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-superAdmin-allLogs">
                                <a href="#endpoints-GETapi-v1-superAdmin-allLogs">GET api/v1/superAdmin/allLogs</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-superAdmin-allActivities--id-">
                                <a href="#endpoints-GETapi-v1-superAdmin-allActivities--id-">GET api/v1/superAdmin/allActivities/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-superAdmin-addresses">
                                <a href="#endpoints-GETapi-v1-superAdmin-addresses">Display a listing of the resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-superAdmin-addresses">
                                <a href="#endpoints-POSTapi-v1-superAdmin-addresses">Store a newly created resource in storage.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-superAdmin-showAddress">
                                <a href="#endpoints-POSTapi-v1-superAdmin-showAddress">Display the specified resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-superAdmin-addresses--id-">
                                <a href="#endpoints-POSTapi-v1-superAdmin-addresses--id-">Update the specified resource in storage.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-v1-superAdmin-addresses--id-">
                                <a href="#endpoints-DELETEapi-v1-superAdmin-addresses--id-">Remove the specified resource from storage.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-superAdmin-roles">
                                <a href="#endpoints-GETapi-v1-superAdmin-roles">Display a listing of the resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-superAdmin-roles">
                                <a href="#endpoints-POSTapi-v1-superAdmin-roles">Store a newly created resource in storage.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-superAdmin-showRoles">
                                <a href="#endpoints-POSTapi-v1-superAdmin-showRoles">Display the specified resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-superAdmin-roles--id-">
                                <a href="#endpoints-POSTapi-v1-superAdmin-roles--id-">Update the specified resource in storage.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-v1-superAdmin-roles--id-">
                                <a href="#endpoints-DELETEapi-v1-superAdmin-roles--id-">Remove the specified resource from storage.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-superAdmin-permissions">
                                <a href="#endpoints-GETapi-v1-superAdmin-permissions">Display a listing of the resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-superAdmin-permissions">
                                <a href="#endpoints-POSTapi-v1-superAdmin-permissions">Store a newly created resource in storage.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-superAdmin-showPermissions">
                                <a href="#endpoints-POSTapi-v1-superAdmin-showPermissions">Show the form for editing the specified resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-superAdmin-permissions--id-">
                                <a href="#endpoints-POSTapi-v1-superAdmin-permissions--id-">Update the specified resource in storage.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-v1-superAdmin-permissions--id-">
                                <a href="#endpoints-DELETEapi-v1-superAdmin-permissions--id-">Remove the specified resource from storage.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-logout">
                                <a href="#endpoints-POSTapi-v1-logout">POST api/v1/logout</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

            <ul class="toc-footer" id="toc-footer">
                            <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
                    </ul>
        <ul class="toc-footer" id="last-updated">
        <li>Last updated: September 30 2022</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<p>This documentation aims to provide all the information about Starbuck you need to work with our API.</p>
<aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).</aside>
<blockquote>
<p>Base URL</p>
</blockquote>
<pre><code class="language-yaml">http://localhost</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-POSTapi-v1-login">POST api/v1/login</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-login">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/login',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-login">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 59
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;The email field is required.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-login"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-login"></code></pre>
</span>
<form id="form-POSTapi-v1-login" data-method="POST"
      data-path="api/v1/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-login"
                    onclick="tryItOut('POSTapi-v1-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-login"
                    onclick="cancelTryOut('POSTapi-v1-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-login" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/login</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-POSTapi-v1-register">POST api/v1/register</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-register">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/register"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/register',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-register">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 58
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;The name field is required.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-register" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-register"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-register"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-register"></code></pre>
</span>
<form id="form-POSTapi-v1-register" data-method="POST"
      data-path="api/v1/register"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-register', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-register"
                    onclick="tryItOut('POSTapi-v1-register');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-register"
                    onclick="cancelTryOut('POSTapi-v1-register');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-register" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/register</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-POSTapi-v1-sendPasswordResetLink">POST api/v1/sendPasswordResetLink</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-sendPasswordResetLink">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/sendPasswordResetLink"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/sendPasswordResetLink',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-sendPasswordResetLink">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 57
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;The email field is required.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-sendPasswordResetLink" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-sendPasswordResetLink"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-sendPasswordResetLink"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-sendPasswordResetLink" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-sendPasswordResetLink"></code></pre>
</span>
<form id="form-POSTapi-v1-sendPasswordResetLink" data-method="POST"
      data-path="api/v1/sendPasswordResetLink"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-sendPasswordResetLink', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-sendPasswordResetLink"
                    onclick="tryItOut('POSTapi-v1-sendPasswordResetLink');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-sendPasswordResetLink"
                    onclick="cancelTryOut('POSTapi-v1-sendPasswordResetLink');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-sendPasswordResetLink" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/sendPasswordResetLink</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-POSTapi-v1-resetPassword">POST api/v1/resetPassword</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-resetPassword">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/resetPassword"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/resetPassword',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-resetPassword">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 56
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;The token field is required.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-resetPassword" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-resetPassword"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-resetPassword"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-resetPassword" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-resetPassword"></code></pre>
</span>
<form id="form-POSTapi-v1-resetPassword" data-method="POST"
      data-path="api/v1/resetPassword"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-resetPassword', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-resetPassword"
                    onclick="tryItOut('POSTapi-v1-resetPassword');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-resetPassword"
                    onclick="cancelTryOut('POSTapi-v1-resetPassword');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-resetPassword" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/resetPassword</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-superAdmin-users">Show the application dashboard.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-superAdmin-users">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/users"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/superAdmin/users',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-superAdmin-users">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 55
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-superAdmin-users" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-superAdmin-users"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-superAdmin-users"></code></pre>
</span>
<span id="execution-error-GETapi-v1-superAdmin-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-superAdmin-users"></code></pre>
</span>
<form id="form-GETapi-v1-superAdmin-users" data-method="GET"
      data-path="api/v1/superAdmin/users"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-superAdmin-users', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-superAdmin-users"
                    onclick="tryItOut('GETapi-v1-superAdmin-users');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-superAdmin-users"
                    onclick="cancelTryOut('GETapi-v1-superAdmin-users');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-superAdmin-users" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/superAdmin/users</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-POSTapi-v1-superAdmin-users">POST api/v1/superAdmin/users</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-superAdmin-users">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/users"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/superAdmin/users',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-superAdmin-users">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 54
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-superAdmin-users" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-superAdmin-users"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-superAdmin-users"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-superAdmin-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-superAdmin-users"></code></pre>
</span>
<form id="form-POSTapi-v1-superAdmin-users" data-method="POST"
      data-path="api/v1/superAdmin/users"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-superAdmin-users', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-superAdmin-users"
                    onclick="tryItOut('POSTapi-v1-superAdmin-users');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-superAdmin-users"
                    onclick="cancelTryOut('POSTapi-v1-superAdmin-users');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-superAdmin-users" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/superAdmin/users</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-POSTapi-v1-superAdmin-userShow">Show the profile for a given user.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-superAdmin-userShow">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/userShow"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/superAdmin/userShow',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-superAdmin-userShow">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 53
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-superAdmin-userShow" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-superAdmin-userShow"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-superAdmin-userShow"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-superAdmin-userShow" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-superAdmin-userShow"></code></pre>
</span>
<form id="form-POSTapi-v1-superAdmin-userShow" data-method="POST"
      data-path="api/v1/superAdmin/userShow"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-superAdmin-userShow', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-superAdmin-userShow"
                    onclick="tryItOut('POSTapi-v1-superAdmin-userShow');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-superAdmin-userShow"
                    onclick="cancelTryOut('POSTapi-v1-superAdmin-userShow');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-superAdmin-userShow" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/superAdmin/userShow</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-POSTapi-v1-superAdmin-users--id-">POST api/v1/superAdmin/users/{id}</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-superAdmin-users--id-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/users/2"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/superAdmin/users/2',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-superAdmin-users--id-">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 52
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-superAdmin-users--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-superAdmin-users--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-superAdmin-users--id-"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-superAdmin-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-superAdmin-users--id-"></code></pre>
</span>
<form id="form-POSTapi-v1-superAdmin-users--id-" data-method="POST"
      data-path="api/v1/superAdmin/users/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-superAdmin-users--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-superAdmin-users--id-"
                    onclick="tryItOut('POSTapi-v1-superAdmin-users--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-superAdmin-users--id-"
                    onclick="cancelTryOut('POSTapi-v1-superAdmin-users--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-superAdmin-users--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/superAdmin/users/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number"
               name="id"
               data-endpoint="POSTapi-v1-superAdmin-users--id-"
               value="2"
               data-component="url" hidden>
    <br>
<p>The ID of the user.</p>
            </p>
                    </form>

                    <h2 id="endpoints-DELETEapi-v1-superAdmin-users--id-">DELETE api/v1/superAdmin/users/{id}</h2>

<p>
</p>



<span id="example-requests-DELETEapi-v1-superAdmin-users--id-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/users/2"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;delete(
    'http://localhost/api/v1/superAdmin/users/2',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-superAdmin-users--id-">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 51
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-v1-superAdmin-users--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-superAdmin-users--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-superAdmin-users--id-"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-superAdmin-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-superAdmin-users--id-"></code></pre>
</span>
<form id="form-DELETEapi-v1-superAdmin-users--id-" data-method="DELETE"
      data-path="api/v1/superAdmin/users/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-superAdmin-users--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-superAdmin-users--id-"
                    onclick="tryItOut('DELETEapi-v1-superAdmin-users--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-superAdmin-users--id-"
                    onclick="cancelTryOut('DELETEapi-v1-superAdmin-users--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-superAdmin-users--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/superAdmin/users/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number"
               name="id"
               data-endpoint="DELETEapi-v1-superAdmin-users--id-"
               value="2"
               data-component="url" hidden>
    <br>
<p>The ID of the user.</p>
            </p>
                    </form>

                    <h2 id="endpoints-POSTapi-v1-superAdmin-changeStatus--id-">POST api/v1/superAdmin/changeStatus/{id}</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-superAdmin-changeStatus--id-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/changeStatus/fugiat"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/superAdmin/changeStatus/fugiat',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-superAdmin-changeStatus--id-">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 50
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-superAdmin-changeStatus--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-superAdmin-changeStatus--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-superAdmin-changeStatus--id-"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-superAdmin-changeStatus--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-superAdmin-changeStatus--id-"></code></pre>
</span>
<form id="form-POSTapi-v1-superAdmin-changeStatus--id-" data-method="POST"
      data-path="api/v1/superAdmin/changeStatus/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-superAdmin-changeStatus--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-superAdmin-changeStatus--id-"
                    onclick="tryItOut('POSTapi-v1-superAdmin-changeStatus--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-superAdmin-changeStatus--id-"
                    onclick="cancelTryOut('POSTapi-v1-superAdmin-changeStatus--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-superAdmin-changeStatus--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/superAdmin/changeStatus/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="id"
               data-endpoint="POSTapi-v1-superAdmin-changeStatus--id-"
               value="fugiat"
               data-component="url" hidden>
    <br>
<p>The ID of the changeStatus.</p>
            </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-superAdmin-userRoles">GET api/v1/superAdmin/userRoles</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-superAdmin-userRoles">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/userRoles"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/superAdmin/userRoles',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-superAdmin-userRoles">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 49
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-superAdmin-userRoles" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-superAdmin-userRoles"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-superAdmin-userRoles"></code></pre>
</span>
<span id="execution-error-GETapi-v1-superAdmin-userRoles" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-superAdmin-userRoles"></code></pre>
</span>
<form id="form-GETapi-v1-superAdmin-userRoles" data-method="GET"
      data-path="api/v1/superAdmin/userRoles"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-superAdmin-userRoles', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-superAdmin-userRoles"
                    onclick="tryItOut('GETapi-v1-superAdmin-userRoles');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-superAdmin-userRoles"
                    onclick="cancelTryOut('GETapi-v1-superAdmin-userRoles');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-superAdmin-userRoles" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/superAdmin/userRoles</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-superAdmin-allLogs">GET api/v1/superAdmin/allLogs</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-superAdmin-allLogs">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/allLogs"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/superAdmin/allLogs',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-superAdmin-allLogs">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 48
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-superAdmin-allLogs" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-superAdmin-allLogs"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-superAdmin-allLogs"></code></pre>
</span>
<span id="execution-error-GETapi-v1-superAdmin-allLogs" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-superAdmin-allLogs"></code></pre>
</span>
<form id="form-GETapi-v1-superAdmin-allLogs" data-method="GET"
      data-path="api/v1/superAdmin/allLogs"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-superAdmin-allLogs', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-superAdmin-allLogs"
                    onclick="tryItOut('GETapi-v1-superAdmin-allLogs');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-superAdmin-allLogs"
                    onclick="cancelTryOut('GETapi-v1-superAdmin-allLogs');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-superAdmin-allLogs" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/superAdmin/allLogs</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-superAdmin-allActivities--id-">GET api/v1/superAdmin/allActivities/{id}</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-superAdmin-allActivities--id-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/allActivities/voluptates"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/superAdmin/allActivities/voluptates',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-superAdmin-allActivities--id-">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 47
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-superAdmin-allActivities--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-superAdmin-allActivities--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-superAdmin-allActivities--id-"></code></pre>
</span>
<span id="execution-error-GETapi-v1-superAdmin-allActivities--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-superAdmin-allActivities--id-"></code></pre>
</span>
<form id="form-GETapi-v1-superAdmin-allActivities--id-" data-method="GET"
      data-path="api/v1/superAdmin/allActivities/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-superAdmin-allActivities--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-superAdmin-allActivities--id-"
                    onclick="tryItOut('GETapi-v1-superAdmin-allActivities--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-superAdmin-allActivities--id-"
                    onclick="cancelTryOut('GETapi-v1-superAdmin-allActivities--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-superAdmin-allActivities--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/superAdmin/allActivities/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="id"
               data-endpoint="GETapi-v1-superAdmin-allActivities--id-"
               value="voluptates"
               data-component="url" hidden>
    <br>
<p>The ID of the allActivity.</p>
            </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-superAdmin-addresses">Display a listing of the resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-superAdmin-addresses">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/addresses"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/superAdmin/addresses',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-superAdmin-addresses">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 46
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-superAdmin-addresses" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-superAdmin-addresses"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-superAdmin-addresses"></code></pre>
</span>
<span id="execution-error-GETapi-v1-superAdmin-addresses" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-superAdmin-addresses"></code></pre>
</span>
<form id="form-GETapi-v1-superAdmin-addresses" data-method="GET"
      data-path="api/v1/superAdmin/addresses"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-superAdmin-addresses', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-superAdmin-addresses"
                    onclick="tryItOut('GETapi-v1-superAdmin-addresses');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-superAdmin-addresses"
                    onclick="cancelTryOut('GETapi-v1-superAdmin-addresses');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-superAdmin-addresses" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/superAdmin/addresses</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-POSTapi-v1-superAdmin-addresses">Store a newly created resource in storage.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-superAdmin-addresses">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/addresses"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/superAdmin/addresses',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-superAdmin-addresses">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 45
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-superAdmin-addresses" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-superAdmin-addresses"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-superAdmin-addresses"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-superAdmin-addresses" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-superAdmin-addresses"></code></pre>
</span>
<form id="form-POSTapi-v1-superAdmin-addresses" data-method="POST"
      data-path="api/v1/superAdmin/addresses"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-superAdmin-addresses', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-superAdmin-addresses"
                    onclick="tryItOut('POSTapi-v1-superAdmin-addresses');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-superAdmin-addresses"
                    onclick="cancelTryOut('POSTapi-v1-superAdmin-addresses');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-superAdmin-addresses" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/superAdmin/addresses</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-POSTapi-v1-superAdmin-showAddress">Display the specified resource.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-superAdmin-showAddress">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/showAddress"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/superAdmin/showAddress',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-superAdmin-showAddress">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 44
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-superAdmin-showAddress" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-superAdmin-showAddress"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-superAdmin-showAddress"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-superAdmin-showAddress" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-superAdmin-showAddress"></code></pre>
</span>
<form id="form-POSTapi-v1-superAdmin-showAddress" data-method="POST"
      data-path="api/v1/superAdmin/showAddress"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-superAdmin-showAddress', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-superAdmin-showAddress"
                    onclick="tryItOut('POSTapi-v1-superAdmin-showAddress');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-superAdmin-showAddress"
                    onclick="cancelTryOut('POSTapi-v1-superAdmin-showAddress');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-superAdmin-showAddress" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/superAdmin/showAddress</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-POSTapi-v1-superAdmin-addresses--id-">Update the specified resource in storage.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-superAdmin-addresses--id-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/addresses/cumque"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/superAdmin/addresses/cumque',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-superAdmin-addresses--id-">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 43
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-superAdmin-addresses--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-superAdmin-addresses--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-superAdmin-addresses--id-"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-superAdmin-addresses--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-superAdmin-addresses--id-"></code></pre>
</span>
<form id="form-POSTapi-v1-superAdmin-addresses--id-" data-method="POST"
      data-path="api/v1/superAdmin/addresses/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-superAdmin-addresses--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-superAdmin-addresses--id-"
                    onclick="tryItOut('POSTapi-v1-superAdmin-addresses--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-superAdmin-addresses--id-"
                    onclick="cancelTryOut('POSTapi-v1-superAdmin-addresses--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-superAdmin-addresses--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/superAdmin/addresses/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="id"
               data-endpoint="POSTapi-v1-superAdmin-addresses--id-"
               value="cumque"
               data-component="url" hidden>
    <br>
<p>The ID of the address.</p>
            </p>
                    </form>

                    <h2 id="endpoints-DELETEapi-v1-superAdmin-addresses--id-">Remove the specified resource from storage.</h2>

<p>
</p>



<span id="example-requests-DELETEapi-v1-superAdmin-addresses--id-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/addresses/sequi"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;delete(
    'http://localhost/api/v1/superAdmin/addresses/sequi',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-superAdmin-addresses--id-">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 42
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-v1-superAdmin-addresses--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-superAdmin-addresses--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-superAdmin-addresses--id-"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-superAdmin-addresses--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-superAdmin-addresses--id-"></code></pre>
</span>
<form id="form-DELETEapi-v1-superAdmin-addresses--id-" data-method="DELETE"
      data-path="api/v1/superAdmin/addresses/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-superAdmin-addresses--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-superAdmin-addresses--id-"
                    onclick="tryItOut('DELETEapi-v1-superAdmin-addresses--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-superAdmin-addresses--id-"
                    onclick="cancelTryOut('DELETEapi-v1-superAdmin-addresses--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-superAdmin-addresses--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/superAdmin/addresses/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="id"
               data-endpoint="DELETEapi-v1-superAdmin-addresses--id-"
               value="sequi"
               data-component="url" hidden>
    <br>
<p>The ID of the address.</p>
            </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-superAdmin-roles">Display a listing of the resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-superAdmin-roles">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/roles"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/superAdmin/roles',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-superAdmin-roles">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 41
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-superAdmin-roles" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-superAdmin-roles"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-superAdmin-roles"></code></pre>
</span>
<span id="execution-error-GETapi-v1-superAdmin-roles" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-superAdmin-roles"></code></pre>
</span>
<form id="form-GETapi-v1-superAdmin-roles" data-method="GET"
      data-path="api/v1/superAdmin/roles"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-superAdmin-roles', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-superAdmin-roles"
                    onclick="tryItOut('GETapi-v1-superAdmin-roles');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-superAdmin-roles"
                    onclick="cancelTryOut('GETapi-v1-superAdmin-roles');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-superAdmin-roles" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/superAdmin/roles</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-POSTapi-v1-superAdmin-roles">Store a newly created resource in storage.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-superAdmin-roles">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/roles"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/superAdmin/roles',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-superAdmin-roles">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 40
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-superAdmin-roles" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-superAdmin-roles"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-superAdmin-roles"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-superAdmin-roles" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-superAdmin-roles"></code></pre>
</span>
<form id="form-POSTapi-v1-superAdmin-roles" data-method="POST"
      data-path="api/v1/superAdmin/roles"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-superAdmin-roles', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-superAdmin-roles"
                    onclick="tryItOut('POSTapi-v1-superAdmin-roles');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-superAdmin-roles"
                    onclick="cancelTryOut('POSTapi-v1-superAdmin-roles');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-superAdmin-roles" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/superAdmin/roles</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-POSTapi-v1-superAdmin-showRoles">Display the specified resource.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-superAdmin-showRoles">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/showRoles"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/superAdmin/showRoles',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-superAdmin-showRoles">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 39
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-superAdmin-showRoles" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-superAdmin-showRoles"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-superAdmin-showRoles"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-superAdmin-showRoles" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-superAdmin-showRoles"></code></pre>
</span>
<form id="form-POSTapi-v1-superAdmin-showRoles" data-method="POST"
      data-path="api/v1/superAdmin/showRoles"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-superAdmin-showRoles', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-superAdmin-showRoles"
                    onclick="tryItOut('POSTapi-v1-superAdmin-showRoles');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-superAdmin-showRoles"
                    onclick="cancelTryOut('POSTapi-v1-superAdmin-showRoles');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-superAdmin-showRoles" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/superAdmin/showRoles</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-POSTapi-v1-superAdmin-roles--id-">Update the specified resource in storage.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-superAdmin-roles--id-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/roles/eum"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/superAdmin/roles/eum',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-superAdmin-roles--id-">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 38
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-superAdmin-roles--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-superAdmin-roles--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-superAdmin-roles--id-"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-superAdmin-roles--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-superAdmin-roles--id-"></code></pre>
</span>
<form id="form-POSTapi-v1-superAdmin-roles--id-" data-method="POST"
      data-path="api/v1/superAdmin/roles/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-superAdmin-roles--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-superAdmin-roles--id-"
                    onclick="tryItOut('POSTapi-v1-superAdmin-roles--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-superAdmin-roles--id-"
                    onclick="cancelTryOut('POSTapi-v1-superAdmin-roles--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-superAdmin-roles--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/superAdmin/roles/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="id"
               data-endpoint="POSTapi-v1-superAdmin-roles--id-"
               value="eum"
               data-component="url" hidden>
    <br>
<p>The ID of the role.</p>
            </p>
                    </form>

                    <h2 id="endpoints-DELETEapi-v1-superAdmin-roles--id-">Remove the specified resource from storage.</h2>

<p>
</p>



<span id="example-requests-DELETEapi-v1-superAdmin-roles--id-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/roles/occaecati"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;delete(
    'http://localhost/api/v1/superAdmin/roles/occaecati',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-superAdmin-roles--id-">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 37
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-v1-superAdmin-roles--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-superAdmin-roles--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-superAdmin-roles--id-"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-superAdmin-roles--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-superAdmin-roles--id-"></code></pre>
</span>
<form id="form-DELETEapi-v1-superAdmin-roles--id-" data-method="DELETE"
      data-path="api/v1/superAdmin/roles/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-superAdmin-roles--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-superAdmin-roles--id-"
                    onclick="tryItOut('DELETEapi-v1-superAdmin-roles--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-superAdmin-roles--id-"
                    onclick="cancelTryOut('DELETEapi-v1-superAdmin-roles--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-superAdmin-roles--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/superAdmin/roles/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="id"
               data-endpoint="DELETEapi-v1-superAdmin-roles--id-"
               value="occaecati"
               data-component="url" hidden>
    <br>
<p>The ID of the role.</p>
            </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-superAdmin-permissions">Display a listing of the resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-superAdmin-permissions">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/permissions"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/superAdmin/permissions',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-superAdmin-permissions">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 36
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-superAdmin-permissions" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-superAdmin-permissions"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-superAdmin-permissions"></code></pre>
</span>
<span id="execution-error-GETapi-v1-superAdmin-permissions" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-superAdmin-permissions"></code></pre>
</span>
<form id="form-GETapi-v1-superAdmin-permissions" data-method="GET"
      data-path="api/v1/superAdmin/permissions"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-superAdmin-permissions', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-superAdmin-permissions"
                    onclick="tryItOut('GETapi-v1-superAdmin-permissions');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-superAdmin-permissions"
                    onclick="cancelTryOut('GETapi-v1-superAdmin-permissions');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-superAdmin-permissions" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/superAdmin/permissions</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-POSTapi-v1-superAdmin-permissions">Store a newly created resource in storage.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-superAdmin-permissions">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/permissions"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/superAdmin/permissions',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-superAdmin-permissions">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 35
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-superAdmin-permissions" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-superAdmin-permissions"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-superAdmin-permissions"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-superAdmin-permissions" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-superAdmin-permissions"></code></pre>
</span>
<form id="form-POSTapi-v1-superAdmin-permissions" data-method="POST"
      data-path="api/v1/superAdmin/permissions"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-superAdmin-permissions', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-superAdmin-permissions"
                    onclick="tryItOut('POSTapi-v1-superAdmin-permissions');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-superAdmin-permissions"
                    onclick="cancelTryOut('POSTapi-v1-superAdmin-permissions');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-superAdmin-permissions" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/superAdmin/permissions</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-POSTapi-v1-superAdmin-showPermissions">Show the form for editing the specified resource.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-superAdmin-showPermissions">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/showPermissions"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/superAdmin/showPermissions',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-superAdmin-showPermissions">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 34
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-superAdmin-showPermissions" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-superAdmin-showPermissions"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-superAdmin-showPermissions"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-superAdmin-showPermissions" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-superAdmin-showPermissions"></code></pre>
</span>
<form id="form-POSTapi-v1-superAdmin-showPermissions" data-method="POST"
      data-path="api/v1/superAdmin/showPermissions"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-superAdmin-showPermissions', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-superAdmin-showPermissions"
                    onclick="tryItOut('POSTapi-v1-superAdmin-showPermissions');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-superAdmin-showPermissions"
                    onclick="cancelTryOut('POSTapi-v1-superAdmin-showPermissions');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-superAdmin-showPermissions" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/superAdmin/showPermissions</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-POSTapi-v1-superAdmin-permissions--id-">Update the specified resource in storage.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-superAdmin-permissions--id-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/permissions/consectetur"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/superAdmin/permissions/consectetur',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-superAdmin-permissions--id-">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 33
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-superAdmin-permissions--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-superAdmin-permissions--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-superAdmin-permissions--id-"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-superAdmin-permissions--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-superAdmin-permissions--id-"></code></pre>
</span>
<form id="form-POSTapi-v1-superAdmin-permissions--id-" data-method="POST"
      data-path="api/v1/superAdmin/permissions/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-superAdmin-permissions--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-superAdmin-permissions--id-"
                    onclick="tryItOut('POSTapi-v1-superAdmin-permissions--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-superAdmin-permissions--id-"
                    onclick="cancelTryOut('POSTapi-v1-superAdmin-permissions--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-superAdmin-permissions--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/superAdmin/permissions/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="id"
               data-endpoint="POSTapi-v1-superAdmin-permissions--id-"
               value="consectetur"
               data-component="url" hidden>
    <br>
<p>The ID of the permission.</p>
            </p>
                    </form>

                    <h2 id="endpoints-DELETEapi-v1-superAdmin-permissions--id-">Remove the specified resource from storage.</h2>

<p>
</p>



<span id="example-requests-DELETEapi-v1-superAdmin-permissions--id-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/superAdmin/permissions/culpa"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;delete(
    'http://localhost/api/v1/superAdmin/permissions/culpa',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-superAdmin-permissions--id-">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 32
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-v1-superAdmin-permissions--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-superAdmin-permissions--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-superAdmin-permissions--id-"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-superAdmin-permissions--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-superAdmin-permissions--id-"></code></pre>
</span>
<form id="form-DELETEapi-v1-superAdmin-permissions--id-" data-method="DELETE"
      data-path="api/v1/superAdmin/permissions/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-superAdmin-permissions--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-superAdmin-permissions--id-"
                    onclick="tryItOut('DELETEapi-v1-superAdmin-permissions--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-superAdmin-permissions--id-"
                    onclick="cancelTryOut('DELETEapi-v1-superAdmin-permissions--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-superAdmin-permissions--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/superAdmin/permissions/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="id"
               data-endpoint="DELETEapi-v1-superAdmin-permissions--id-"
               value="culpa"
               data-component="url" hidden>
    <br>
<p>The ID of the permission.</p>
            </p>
                    </form>

                    <h2 id="endpoints-POSTapi-v1-logout">POST api/v1/logout</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-logout">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/logout"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/logout',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-logout">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
access-control-allow-methods: GET, POST, PUT, DELETE, OPTIONS
x-ratelimit-limit: 60
x-ratelimit-remaining: 31
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-logout" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-logout"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-logout"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-logout"></code></pre>
</span>
<form id="form-POSTapi-v1-logout" data-method="POST"
      data-path="api/v1/logout"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-logout', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-logout"
                    onclick="tryItOut('POSTapi-v1-logout');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-logout"
                    onclick="cancelTryOut('POSTapi-v1-logout');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-logout" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/logout</code></b>
        </p>
                    </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                                                        <button type="button" class="lang-button" data-language-name="php">php</button>
                            </div>
            </div>
</div>
</body>
</html>
