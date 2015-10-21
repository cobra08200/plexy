{{-- @if (count($errors->all()) > 0)
<header>
	@if(isset($messages))
		@foreach ($messages as $m)
			{{ $m }}
		@endforeach
	@endif
</header>
@endif --}}

@if ($message = Session::get('success'))
<header class="header-success">
    @if(is_array($message))
        @foreach ($message as $m)
            {{ $m }}
        @endforeach
    @else
        {{ $message }}
    @endif
</header>
@endif

@if ($message = Session::get('info'))
<header class="header-info">
    @if(is_array($message))
	    @foreach ($message as $m)
	    	{{ $m }}
	    @endforeach
    @else
    	{{ $message }}
    @endif
</header>
@endif

@if ($message = Session::get('warning'))
<header class="header-warning">
    @if(is_array($message))
	    @foreach ($message as $m)
	    	{{ $m }}
	    @endforeach
    @else
    	{{ $message }}
    @endif
</header>
@endif

@if ($message = Session::get('danger'))
<header class="header-danger">
    @if(is_array($message))
	    @foreach ($message as $m)
	    	{{ $m }}
	    @endforeach
    @else
    	{{ $message }}
    @endif
</header>
@endif
