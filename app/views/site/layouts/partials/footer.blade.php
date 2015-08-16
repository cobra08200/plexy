@if(Auth::check())
<!-- Footer -->
<hr>

<!-- Footer -->
<footer>
		<div class="row">
				<div class="col-lg-12">
					<p>
						@yield('footer')
					</p>
				</div>
		</div>
		<!-- /.row -->
</footer>
<!-- ./ Footer -->

<!-- Javascripts -->
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/2.0.0/handlebars.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>
{{-- <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script> --}}
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
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
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-66020287-1', 'auto');
  ga('send', 'pageview');

</script>
@yield('scripts')
@else
<div id="footer">
	<div class="container">
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-66020287-1', 'auto');
  ga('send', 'pageview');

</script>
@yield('scripts')
@endif
