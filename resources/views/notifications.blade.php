@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if ($message = Session::get('success'))
<header class="header-success">
    @if (is_array($message))
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
    @if (is_array($message))
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
    @if (is_array($message))
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
    @if (is_array($message))
	    @foreach ($message as $m)
	    	{{ $m }}
	    @endforeach
    @else
    	{{ $message }}
    @endif
</header>
@endif
