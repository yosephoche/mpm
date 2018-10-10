<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="apple-mobile-web-app-capable" content="yes">
    <meta content="telephone=no" name="format-detection">
    <meta content="maximum-dpr=2" name="flexible"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-touch-fullscreen" content="no"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
	<title>MPM</title>
	<!-- inject:css -->
	<link rel="stylesheet" href="{{ URL('/assets/stylesheets/app.min.css') }}">
	<!-- endinject -->
	<!-- inject:js -->
	<script src="{{ URL('/assets/js/app.min.js') }}"></script>
	<!-- endinject -->
</head>
<body>
	<div class="main-login _404">
		<div class="ml-wrapper">
			<div class="ml-inner">
				<div class="uk-clearfix">
					<div class="left uk-float-right uk-hidden-small">
						<div class="form-image _404"></div>
					</div>
					<div class="right uk-text-center _404">
						<div class="header">
							<h3>{{$code}}</h3>
						</div>
						<div action="" class="ml-form _404">
							<p>{{$message}}</p>
						</div>
						<div class="footer _404 uk-text-center">
							<a href="{{ URL('/') }}"><i class="uk-icon-angle-left"></i> Kembali ke halaman utama.</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div><!-- main -->
	<footer class="footer-login">
		<div class="gf-content">
			<div class="uk-text-center">
				<small>2017 Bappeda Kabupaten Soppeng. Developer</small>
			</div>
		</div>
	</footer>
	<style>
	.main-login._404::before {
	    background: rgba(0, 0, 0, 0) url("/assets/img/404-bg.jpg") no-repeat scroll center top / cover ;
	}
	.main-login .ml-wrapper .ml-inner .left .form-image._404 {
	    background: rgba(0, 0, 0, 0) url("/assets/img/404-bg-left.jpg") no-repeat scroll center center / cover ;
	}
	</style>
</body>
</html>