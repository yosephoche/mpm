@extends('Dashboard::layouts.main')

@section('content')
<div id="pendaftaran-mpm-content" class="m-content">
	<div class="mc-header">
		<style>
			#pendaftaran-mpm-content > .mc-header {
				background: url('/assets/img/pmpm.jpg') no-repeat center center;
				background-size: cover;
			}
		</style>
		<div class="mch-text">
			<h2>Daftar Peserta Individu</h2>
		</div>
	</div>
	<div class="mc-breadcrumb" data-uk-sticky="{top:60}">
		<ul class="uk-breadcrumb">
			<li><a href="{{ URL('/dashboard') }}">Dashboard</a></li>
			<li><a href="{{ URL('/induk/individu') }}">Data Induk BDT Individu</a></li>
			<li><a href="javascript:;">Daftar Peserta Individu</a></li>
		</ul>
	</div>
	<div class="mc-form">
		<div class="mc-form-wrapper">
			<div class="mc-form-inner">
				<div>
					<div class="mcf-content">
						<div class="mcf-title">
							<h3>Daftar Peserta Individu MPM</h3>
						</div>
						<div class="main-table">
							<div class="mt-wrapper">
								<div class="mt-inner">
									
									<div>
										Jumlah Peserta <b>{{$jumpeserta[0]->count}}</b> Anggota
										<br>
										<table class="uk-table uk-table-hover">
											<thead>
												<tr>
													<th>No.</th>
													<th>No. Urut RT</th>
													<th>No. Urut ART</th>
													<th>No. Urut Keluarga</th>
													<th>NIK</th>
													<th>Nama</th>
													<th>Jenis Kelamin</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												@php($i = 1)
												@for($ind = 0; $ind < count($peserta->individu);$ind++)
												@if($peserta->individu[$ind]['status'] == 1)
												<tr>
													<td>{{ $i++ }}</td>
													<td>{{ (array_key_exists('nourut_rt',  $peserta->individu[$ind]) ? $peserta->individu[$ind]['nourut_rt'] : '') }}</td>
													<td>{{ (array_key_exists('no_art',  $peserta->individu[$ind]) ? $peserta->individu[$ind]['no_art'] : '') }}</td>
													<td>{{ (array_key_exists('b4_k4',  $peserta->individu[$ind]) ? $peserta->individu[$ind]['b4_k4'] : '') }}</td>
													<td>{{ (array_key_exists('nik',  $peserta->individu[$ind]) ? $peserta->individu[$ind]['nik'] : '') }}</td>
													<td>{{(array_key_exists('nama',  $peserta->individu[$ind]) ? $peserta->individu[$ind]['nama'] : '') }}</td>
													<td>{{ (array_key_exists('b4_k6',  $peserta->individu[$ind]) ? (($peserta->individu[$ind]['b4_k6'] == '1') ? 'Laki-laki' : 'Perempuan') : '') }}</td>
													<td>
														<div class="uk-button-group">
															<button class="uk-button" type="button">Aksi</button>
															<div data-uk-dropdown="{mode:'click', pos:'bottom-right'}">
																<button class="uk-button" type="button"><i class="uk-icon-caret-down"></i></button>
																<div class="uk-dropdown uk-dropdown-small">
																	<ul>
																		<li><a href="{{ URL('/induk/individu/detail/art').'/'.$peserta->kodepeserta.'/'.$peserta->individu[$ind]['_id'] }}">Detail Individu</a></li>
																	</ul>
																</div>
															</div>
														</div>
													</td>
												</tr>
												@endif
												@endfor
											</tbody>
										</table>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>


<script>
	var sidebar = 'sidebar-finduk-individu';
</script>
<script type="text/javascript" src="{{ url('/assets/js/jquery.printPage.js') }}"></script>
<script src="{{ URL('/assets/js/backend/induk.js') }}"></script>
@stop
