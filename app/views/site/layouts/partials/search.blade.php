{{ Form::open(array('route' => 'movies.search', 'class' => 'navbar-form navbar-left', 'role' => 'search')) }}
<div class="form-group">
{{ Form::text('title', '', array('class' => 'typeahead form-control','placeholder' => 'Title')) }}
{{ Form::hidden('title', '', array('id' => 'title')) }}
{{ Form::hidden('year', '', array('id' => 'year')) }}
{{ Form::hidden('tmdb', '', array('id' => 'tmdb')) }}
{{ Form::hidden('poster', '', array('id' => 'poster')) }}
{{ Form::hidden('backdrop', '', array('id' => 'backdrop')) }}
{{ Form::hidden('topic', '', array('id' => 'topic')) }}
{{ Form::hidden('vote_average', '', array('id' => 'vote_average')) }}
{{ Form::submit('Request', array('class' => 'btn btn-default', 'name' => 'type')) }}
{{ Form::submit('Issue', array('class' => 'btn btn-default', 'name' => 'type')) }}
</div>
{{ Form::close() }}
