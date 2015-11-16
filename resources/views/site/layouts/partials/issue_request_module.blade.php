<header>{{ $header }}</header>
@foreach ($module->all() as $unit)
    <img src="{{ $unit['poster_url'] }}" width="200px">
    <a href="{{ route('issue.id', ['id' => $unit['id']]) }}">
        <p>{{ $unit['content'] }}</p>
    </a>
    <p>Status: {{ ucwords($unit['status']) }}</p>
    @if($unit['user_id'] === Auth::id())
        <p>This is your ticket.</p>
    @endif
    @if($unit['type'] === 'issue')
        <p>Type: Issue</p>
        @if($unit['topic'] === 'movies')
        @endif
        @if($unit['topic'] === 'tv')
        <p>
            @if(isset($unit['tv_season_number']))
                Season {{ $unit['tv_season_number'] }}
            @endif
            @if(isset($unit['tv_episode_number']))
                - Episode {{ $unit['tv_episode_number'] }}
            @endif
        </p>
        @endif
        @if($unit['topic'] === 'music')
        <p>
            @if(isset($unit['tv_season_number']))
                Track {{ $unit['album_track_number'] }}
            @endif
        </p>
        @endif
    @elseif($unit['type'] === 'request')
    <p>Type: Request</p>
    @endif
@endforeach
