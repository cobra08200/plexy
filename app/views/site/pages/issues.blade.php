@extends('admin.layouts.default')

<?php
define('DISQUS_SECRET_KEY', 'IsNynpAZO4xzjklvboqeNHo91a1tkBLSeLl4zchOTq4fwGinpBJXMOYznWZgEYyn');
define('DISQUS_PUBLIC_KEY', 'wwZyMeih66TmTi6ni634aKxEuzLK86f6i2vt81HaEFp1amk0VAs4FVmNI4cn2mtH');

$data = array(
	"id" => Auth::id(),
	"username" => Auth::user()->username,
	"email" => Auth::user()->email
	);

function dsq_hmacsha1($data, $key) {
	$blocksize=64;
	$hashfunc='sha1';
	if (strlen($key)>$blocksize)
		$key=pack('H*', $hashfunc($key));
	$key=str_pad($key,$blocksize,chr(0x00));
	$ipad=str_repeat(chr(0x36),$blocksize);
	$opad=str_repeat(chr(0x5c),$blocksize);
	$hmac = pack(
		'H*',$hashfunc(
			($key^$opad).pack(
				'H*',$hashfunc(
					($key^$ipad).$data
					)
				)
			)
		);
	return bin2hex($hmac);
}

$message = base64_encode(json_encode($data));
$timestamp = time();
$hmac = dsq_hmacsha1($message . ' ' . $timestamp, DISQUS_SECRET_KEY);
?>
<script type="text/javascript">
	var disqus_config = function() {
		this.page.remote_auth_s3 = "<?php echo "$message $hmac $timestamp"; ?>";
		this.page.api_key = "<?php echo DISQUS_PUBLIC_KEY; ?>";
	}
</script>

@section('content')

<div class="row">
	<div class="col-md-12">
		<h1 class="text-center">
			{{ $issue->content }}
		</h1>
		<img src="{{ $issue->poster_url }}">
	</div>

	<div id="disqus_thread"></div>
	<script type="text/javascript">
		/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
	var disqus_shortname = 'plexy'; // Required - Replace example with your forum shortname
	var disqus_identifier = '{{ $issue->id }}';
	var disqus_url = '{{ URL::full() }}';

	/* * * DON'T EDIT BELOW THIS LINE * * */
	(function() {
		var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
		dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
		(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
	})();
</script>
<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>

@stop