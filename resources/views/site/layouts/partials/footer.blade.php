@if (env('APP_ENV') == 'production')
<script src="{{secure_asset('assets/js/jquery.min.js')}}"></script>
<script src="{{secure_asset('assets/js/semantic.min.js')}}"></script>
<script src="{{secure_asset('assets/js/select2.full.min.js')}}"></script>
{{-- <script src="{{ elixir('js/all.js') }}"></script> --}}
@else
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/semantic.min.js')}}"></script>
<script src="{{asset('assets/js/select2.full.min.js')}}"></script>
{{-- <script src="{{ elixir('js/all.js') }}"></script> --}}
@endif
@yield('scripts')
