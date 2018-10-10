<!DOCTYPE html>
<html>
<head>
	@include('Front::includes.meta')
</head>
<body class="home">
@include('Front::includes.header')
@yield('content')
@include('Front::includes.footer')

<!-- <script src="{{ URL('/assets/js/vendor.js') }}"></script> -->
</body>
</html>