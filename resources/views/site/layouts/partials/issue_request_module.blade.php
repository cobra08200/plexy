<header>{{ $header }}</header>
@foreach($module->all() as $unit)
    <h2>
        <img src="{{ $unit->poster_url }}" width="200px">
    </h2>
    <h2>{{ $unit->content }}</h2>
    <p>Status: {{ ucwords($unit->status) }}</p>
    <a href="{{ route('issue.id', ['id' => $unit->id]) }}">
        <b>View Details</b>
    </a>
@endforeach
