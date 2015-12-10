@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

{{-- <h1 class="ui center aligned header">H1</h1> --}}
<form class="ui form" method="post" action="{{ route('login.post') }}">
  {!! csrf_field() !!}
  <div class="field">
    <label>Username or Email Address</label>
    <input type="text" name="username_or_email" id="username_or_email" value="{{ old('username_or_email') }}">
  </div>
  <div class="field">
    <label>Password</label>
    <input type="password" name="password" id="password" >
  </div>
  <div class="field">
    <div class="ui checkbox">
      <input type="checkbox" name="remember" {{ old('remember') ? ' checked' : '' }}>
      <label>Remember Me</label>
    </div>
  </div>
  <button class="ui button" type="submit" id="submit_button">Submit</button>
</form>

@stop

{{-- @section('scripts')

<script>
var xhr;

$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

$('#username_or_email').on("input", function() {
var username_or_email = this.value;
if (xhr && xhr.readyState != 4) {
xhr.abort();
}
var xhr = $.ajax({
url:'{{ url('plex/verify/') }}/'+username_or_email+'/',
type:'POST',
dataType:'json',
contentType: "application/json",
data: JSON.stringify(username_or_email),
success: function (data) {
if (data.success)
{
$("#submit_button").prop("disabled", false);
}
},
error: function (data) {
}
});
});

var $loading = $('#loadingDiv');

$(document)
.ajaxStart(function () {
$("#submit_button").prop("disabled", true);
$loading.toggle();
})
.ajaxStop(function () {
$loading.toggle();
});
</script>

@stop --}}
