@if(Auth::check())
<!-- Footer -->
<footer class="clearfix">
	@yield('footer')
</footer>
<!-- ./ Footer -->

<!-- Javascripts -->
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/handlebars.js/2.0.0/handlebars.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
{{--
<script src="{{asset('assets/js/wysihtml5/wysihtml5-0.3.0.js')}}"></script>
<script src="{{asset('assets/js/wysihtml5/bootstrap-wysihtml5.js')}}"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script src="{{asset('assets/js/datatables-bootstrap.js')}}"></script>
<script src="{{asset('assets/js/datatables.fnReloadAjax.js')}}"></script>
<script src="{{asset('assets/js/jquery.colorbox.js')}}"></script>
<script src="{{asset('assets/js/prettify.js')}}"></script>
--}}
<script src="{{asset('assets/js/custom.js')}}"></script>

{{--
<script type="text/javascript">
	$('.wysihtml5').wysihtml5();
	$(prettyPrint);
</script>
--}}

@yield('scripts')
@else
<div id="footer">
	<div class="container">
	</div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
@yield('scripts')
@endif
