@if(Auth::user()->hasRole('butter'))
has role
@else
does not have
@endif
