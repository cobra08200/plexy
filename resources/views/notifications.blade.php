@if ($message = Session::get('success'))
<div class="ui positive message">
  <i class="close icon"></i>
  <div class="header">
    @if (is_array($message))
    @foreach ($message as $m)
    {{ $m }}
    @endforeach
    @else
    {{ $message }}
    @endif
  </div>
</div>
@endif

@if ($message = Session::get('info'))
<div class="ui info message">
  <i class="close icon"></i>
  <div class="header">
    @if (is_array($message))
    @foreach ($message as $m)
    {{ $m }}
    @endforeach
    @else
    {{ $message }}
    @endif
  </div>
</div>
@endif

@if ($message = Session::get('warning'))
<div class="ui warning message">
  <i class="close icon"></i>
  <div class="header">
    @if (is_array($message))
    @foreach ($message as $m)
    {{ $m }}
    @endforeach
    @else
    {{ $message }}
    @endif
  </div>
</div>
@endif

@if ($message = Session::get('danger'))
<div class="ui negative message">
  <i class="close icon"></i>
  <div class="header">
    @if (is_array($message))
    @foreach ($message as $m)
    {{ $m }}
    @endforeach
    @else
    {{ $message }}
    @endif
  </div>
</div>
@endif

@if (count($errors) > 0)
<div class="ui negative message">
  <i class="close icon"></i>
  <div class="header">
    Something unexpected happened.
  </div>
  <ul class="list">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
