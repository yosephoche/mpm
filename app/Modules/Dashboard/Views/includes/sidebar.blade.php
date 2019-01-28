<div class="m-sidebar">
	<div class="">

		<div class="ms-account uk-text-center">
			<div class="msa-image">
				<div class="msa-image-inner">
					<img src="{{ URL('/assets/img/user_icon.png') }}" alt="">
				</div>
			</div>
			<div class="msa-text">
				<div class="msa-text-wrapper">
					<div class="msa-text-inner">
						<h2>{{ strtoupper(auth()->guard('admin')->user()->fullname) }}</h2>
					</div>
				</div>
			</div>
		</div>
		<nav class="ms-nav">
			<ul class="msn-list uk-nav uk-nav-side uk-nav-parent-icon" data-uk-nav="{multiple:true}">
				<li class="msn-item uk-active">
					<a href="{{ URL('/dashboard') }}" class="msn-link"><i class="uk-icon-home"></i>Dashboard</a>
				</li>
				@if(auth()->guard('admin')->user()->status_admin != 3)
				<li class="msn-item uk-parent" id="sidebar-fmpm">
					<a href="#" class="msn-link"><i class="uk-icon-edit"></i>Pendaftaran</a>
					<ul class="uk-nav-sub">
						<li id="sidebar-fmpm-pendaftaran"><a href="{{ URL('/mpm/registrasi') }}"><i class="uk-icon-circle-o"></i>Pendaftaran MPM</a></li>
						<li id="sidebar-fmpm-list"><a href="{{ URL('/mpm') }}"><i class="uk-icon-circle-o"></i>Daftar Peserta MPM</a></li>
					</ul>
				</li>
				<li class="msn-item uk-parent" id="sidebar-fppfm">
					<a href="#" class="msn-link"><i class="uk-icon-file-text"></i>Data Terpadu PPFM</a>
					<ul class="uk-nav-sub">
						<li id="sidebar-fppfm-belum"><a href="{{ URL('/ppfm/peserta-baru') }}"><i class="uk-icon-circle-o"></i>Belum Terdaftar</a></li>
						<li id="sidebar-fppfm-sudah"><a href="{{ URL('/ppfm/peserta-lama') }}"><i class="uk-icon-circle-o"></i>Sudah Terdaftar</a></li>
					</ul>
				</li>
				<li class="msn-item uk-parent" id="sidebar-findukbdt">
					<a href="#" class="msn-link"><i class="uk-icon-file-zip-o"></i>Data Induk BDT</a>
					<ul class="uk-nav-sub">
						<li id="sidebar-finduk-individu"><a href="{{ URL('/induk/individu') }}"><i class="uk-icon-circle-o"></i>Individu</a></li>
						<li id="sidebar-finduk-rt"><a href="{{ URL('/induk/rumahtangga') }}"><i class="uk-icon-circle-o"></i>Rumah Tangga</a></li>
					</ul>
				</li>
				@endif
				@if(auth()->guard('admin')->user()->status_admin == 0 || auth()->guard('admin')->user()->status_admin == 3)
				<li id="sidebar-dm" class="msn-item uk-parent">
					<a href="#" class="msn-link"><i class="uk-icon-download"></i>Data Master</a>
					<ul class="uk-nav-sub">
						@if(auth()->guard('admin')->user()->status_admin != 3)
						<li id="sidebar-dm-indikator-variabel" class=""><a href="{{ URL('/master/indikator/variabel') }}"><i class="uk-icon-circle-o"></i>Indikator Variabel</a></li>
						<li id="sidebar-dm-indikator-opsi" class=""><a href="{{ URL('/master/indikator/opsi') }}"><i class="uk-icon-circle-o"></i>Opsi Indikator</a></li>
						<li id="sidebar-dm-opd" class=""><a href="{{ URL('/master/opd') }}"><i class="uk-icon-circle-o"></i>OPD</a></li>
						@endif
						<li id="sidebar-dm-jenis-kegiatan" class=""><a href="{{ URL('/master/jenis-kegiatan') }}"><i class="uk-icon-circle-o"></i>Jenis Kegiatan</a></li>
						{{--<li id="sidebar-dm-indikator-kegiatan" class=""><a href="{{ URL('/master/indikator-kegiatan') }}"><i class="uk-icon-circle-o"></i>Indikator Kegiatan</a></li>--}}
						<li id="sidebar-dm-tahun-anggaran" class=""><a href="{{ URL('/master/tahun-anggaran') }}"><i class="uk-icon-circle-o"></i>Tahun Anggaran</a></li>
	<!-- 					<li><a href="#"><i class="uk-icon-circle-o"></i>Perubahan Data PPFM</a></li>
	<li><a href="#"><i class="uk-icon-circle-o"></i>Daftar Peserta PPFM</a></li> -->
					</ul>
				</li>
				@endif
				@if (auth()->guard('admin')->user()->status_admin == 3 || auth()->guard('admin')->user()->status_admin == 0)
					<li id="sidebar-anggaran-kegiatan" class="msn-item">
						<a href="{{ URL('/anggaran-kegiatan') }}" class="msn-link"><i class="uk-icon-user"></i>Anggaran Kegiatan</a>
					</li>
				@endif
				@if(auth()->guard('admin')->user()->status_admin == 0 || auth()->guard('admin')->user()->status_admin == 1)
				<li id="sidebar-user" class="msn-item">
					<a href="{{ URL('/pengguna') }}" class="msn-link"><i class="uk-icon-user"></i>Pengguna</a>
				</li>
				@endif
			</ul>
		</nav>
	</div>
</div>
