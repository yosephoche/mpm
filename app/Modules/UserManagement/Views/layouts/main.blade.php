<!DOCTYPE html>
<html>
<head>
	@include('UserManagement::includes.meta')
</head>
<body class="home">
@include('UserManagement::includes.header')
@yield('content')
@include('UserManagement::includes.footer')

<!-- <script src="{{ URL('/assets/js/vendor.js') }}"></script> -->
</body>
</html>