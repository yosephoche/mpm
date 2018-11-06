@extends('Front::layouts.main')

@section('content')
<div class="content">
	<div class="uk-vertical-align uk-panel uk-panel-box">
		<div class="uk-vertical-align-middle">
			<h2>Selamat Datang</h2>
			<ul>
				<li><a href="{{ URL('/tentang') }}">TENTANG Si EMAS</a></li>
				<li><a href="{{ URL('/globallogin') }}">LOGIN</a></li>
			</ul>
		</div>
	</div>
</div>
<div class="home-content uk-slidenav-position" data-uk-slideshow="{kenburns:true, kenburns: '50s', autoplay:true, duration: 1000}">
	<ul class="uk-slideshow">
		<li>
			<div id="_1" data-src="/assets/img/person.jpg" class="hc-item uk-cover-background uk-position-cover uk-animation-scale uk-animation-reverse uk-animation-center-center"></div>
			
		</li>
		<li>
			<div id="_2" data-src="/assets/img/cambodia.jpg" class="hc-item uk-cover-background uk-position-cover uk-animation-scale uk-animation-center-center"></div>
			
		</li>
		<li>
			<div id="_3" data-src="/assets/img/saigon.jpg" class="hc-item uk-cover-background uk-position-cover uk-animation-scale uk-animation-reverse uk-animation-center-center"></div>
			
		</li>
		<li>
			<div id="_4" data-src="/assets/img/thailand1.jpg" class="hc-item uk-cover-background uk-position-cover uk-animation-scale uk-animation-center-center"></div>
			
		</li>
		<li>
			<div id="_5" data-src="/assets/img/laos.jpg" class="hc-item uk-cover-background uk-position-cover uk-animation-scale uk-animation-reverse uk-animation-center-center"></div>
			
		</li>
	</ul>
	<ul class="uk-dotnav uk-dotnav-contrast uk-position-bottom uk-flex-center">
		<li data-uk-slideshow-item="0"><a href=""></a></li>
		<li data-uk-slideshow-item="1"><a href=""></a></li>
		<li data-uk-slideshow-item="2"><a href=""></a></li>
		<li data-uk-slideshow-item="3"><a href=""></a></li>
		<li data-uk-slideshow-item="4"><a href=""></a></li>
	</ul>
</div>
@stop