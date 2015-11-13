<header>{{ $header }}</header>
@foreach($module->all() as $unit)
    <img src="{{ $unit->poster_url }}" width="200px">
    <a href="{{ route('issue.id', ['id' => $unit->id]) }}">
        <p>{{ $unit->content }}</p>
    </a>
    {{-- <p>Status: {{ ucwords($unit->status) }}</p> --}}
@endforeach
