<!DOCTYPE html>
<html>
<head>
	@include('Dashboard::includes.meta')
</head>
<body>
@include('Dashboard::includes.header')
<div class="main">
@include('Dashboard::includes.sidebar')
@yield('content')
</div>
@include('Dashboard::includes.footer')

<!-- <script src="{{ URL('/assets/js/vendor.js') }}"></script> -->
</body>
</html>