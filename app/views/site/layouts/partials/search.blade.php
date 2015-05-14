@if(Request::path() === '/')
{{ Form::open(array('route' => 'movies.search', 'class' => 'search__form', 'role' => 'search')) }}
<div class="form-group">
{{ Form::hidden('title', '', array('id' => 'title')) }}
{{ Form::hidden('year', '', array('id' => 'year')) }}
{{ Form::hidden('tmdb', '', array('id' => 'tmdb')) }}
{{ Form::hidden('poster', '', array('id' => 'poster')) }}
{{ Form::hidden('backdrop', '', array('id' => 'backdrop')) }}
{{ Form::hidden('topic', '', array('id' => 'topic')) }}
{{ Form::hidden('vote_average', '', array('id' => 'vote_average')) }}

{{ Form::text('title', '', array('class' => 'typeahead form-control search__input','placeholder' => 'Title')) }}

<div class="search__actions">
    {{ Form::submit('Request', array('class' => 'btn btn-default', 'name' => 'type')) }}
</div>
    {{-- {{ Form::submit('Report an Issue', array('class' => 'btn btn-default report button__text', 'name' => 'type', 'value' => 'Issue')) }} --}}
    <button type="submit" name="type" value="Issue" class="btn btn-default report button--text">Report an Issue</button>
</div>
{{ Form::close() }}
@endif
