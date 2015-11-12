
@if (env('APP_ENV') == 'production')
<script src="{{secure_asset('assets/js/jquery-2.1.1.js')}}"></script>
{{-- <script src="{{secure_asset('assets/js/main.js')}}"></script> --}}
{{-- <script src="{{secure_asset('assets/js/fittext.js')}}"></script> --}}
{{-- <script src="{{secure_asset('assets/js/handlebars.min.js')}}"></script> --}}
{{-- <script src="{{secure_asset('assets/js/typeahead.bundle.min.js')}}"></script> --}}
<script src="{{secure_asset('assets/js/select2.full.js')}}"></script>
<script src="{{ elixir('js/all.js') }}"></script>
{{-- <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js" type="text/javascript"></script> --}}
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-66020287-1', 'auto');
  ga('send', 'pageview');
</script>
@else
<script src="{{asset('assets/js/jquery-2.1.1.js')}}"></script>
{{-- <script src="{{asset('assets/js/main.js')}}"></script> --}}
{{-- <script src="{{asset('assets/js/fittext.js')}}"></script> --}}
{{-- <script src="{{asset('assets/js/handlebars.min.js')}}"></script> --}}
{{-- <script src="{{asset('assets/js/typeahead.bundle.min.js')}}"></script> --}}
<script src="{{asset('assets/js/select2.full.js')}}"></script>
<script src="{{ elixir('js/all.js') }}"></script>
{{-- <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js" type="text/javascript"></script> --}}
@endif
@yield('scripts')
