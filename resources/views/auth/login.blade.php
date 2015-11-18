@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

<form method="POST" action="{{ route('login.post') }}">
    {!! csrf_field() !!}

    <div class="form-group">
        <label for="email">Username or Email Address:</label>
        <input type="text" name="username_or_email" id="username_or_email" class="form-control" value="{{ old('username_or_email') }}">
    </div>

    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>

    <div class="checkbox">
        <label>
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? ' checked' : '' }}> Remember Me
        </label>
    </div>

    <div class="form-group">
        <button type="submit" id="submit_button" class="btn btn-default">Sign In</button>
    </div>
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
