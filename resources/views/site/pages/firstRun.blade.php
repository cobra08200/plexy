@if (session('firstRun') == 'triggered')
<p>
    Environment variables missing. Please check your .env file.
</p>

@if (env('TMDB_TOKEN') == null)
<ul>
    <li>The Movie DB Token is missing.</li>
</ul>
@endif

@if (env('PLEX_TOKEN') == null)
<ul>
    <li>Plex Token is missing.</li>
</ul>
@endif

@if (env('PLEX_SERVER_URL') == null)
<ul>
    <li>Plex Server URL is missing.</li>
</ul>
@endif

@else
Nothing to see here.
@endif
