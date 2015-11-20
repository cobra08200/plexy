@if (session('firstRun') == 'triggered')
<p>
    Environment variables missing. Please check your .env file.
</p>

@if (env('TMDB_TOKEN') == null || env('PLEX_SERVER_URL') == null)
<ul>
    @if (env('TMDB_TOKEN') == null)
        <li>The Movie DB Token is missing.</li>
    @endif

    @if (env('PLEX_SERVER_URL') == null)
        <li>Plex Server URL is missing.</li>
    @endif
</ul>
@endif

@else
Nothing to see here.
@endif
