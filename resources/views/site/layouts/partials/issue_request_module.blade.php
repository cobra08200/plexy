<h4 class="ui horizontal divider header">
  <i class="ticket icon"></i>
  {{ $header }}
</h4>

<div class="ui four stackable special cards">
  @foreach ($module->all() as $unit)
  <div class="card">
    <div class="blurring dimmable image">
      <div class="ui dimmer">
        <div class="content">
          <div class="center">
            <a class="launch modal" href="{{ route('issue.id', ['id' => $unit['id']]) }}" data-target="#modal">
              <div class="ui inverted button">View More</div>
            </a>
          </div>
        </div>
      </div>
      <img src="{{ $unit['poster_url'] }}">
    </div>
    <div class="content">
      <p class="header">{{ $unit['content'] }}</p>
      <div class="meta">
        <span class="date">
          <i class="ticket icon"></i>
          {{ ucwords($unit['status']) }}
        </span>
        <span class="date">
          @if ($unit['topic'] === 'movies')
          @endif
          @if ($unit['topic'] === 'tv')
            @if (isset($unit['tv_season_number']))
            <p>
              <i class="film icon"></i>
              Season {{ $unit['tv_season_number'] }}
              @endif
              @if (isset($unit['tv_episode_number']))
              - Episode {{ $unit['tv_episode_number'] }}
            </p>
            @endif
          @endif
          @if ($unit['topic'] === 'music')
            @if (isset($unit['tv_season_number']))
            <p>
              <i class="music icon"></i>
              Track {{ $unit['album_track_number'] }}
            </p>
            @endif
          @endif
        </span>
      </div>
    </div>
    @if ($unit['user_id'] === Auth::id())
    <a class="ui red right corner label ticket" data-content="This is your ticket" data-position="left center">
      <i class="idea icon"></i>
    </a>
    @endif
    <div class="extra content">
        <i class="tag icon"></i>
        @if ($unit['type'] === 'issue')
        Issue
        @elseif($unit['type'] === 'request')
        Request
        @endif
    </div>
  </div>
  @endforeach
</div>
