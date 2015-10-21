<header>{{ $header }}</header>
@foreach($module->all() as $unit)
    <a href="{{ URL::to('issue') }}/{{ $unit->id }}">
        <h2>
            <img src="{{ $unit->poster_url }}" width="200px">
        </h2>
        <h2>{{ $unit->content }}</h2>
        <p>Status: {{ ucwords($unit->status) }}</p>
        <b>View Details</b>
    </a>
@endforeach
