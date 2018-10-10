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
	<div class="mc-form mc-form-detail">
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
									<div class="mcf-detail-page">
										<ul class="mcf-list">
											<li class="mcf-item">
												<div class="data uk-grid">
													<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
														<div class="data-inner">
															<label for="provinsi-1">No. Urut Anggota Rumah Tangga</label>
															<input id="nik" type="text" name="nik" value="{{ (array_key_exists('no_art',  $peserta[0]->individu) ? $peserta[0]->individu['no_art'] : '') }}" readonly>
															<!-- <div class="error">Pesan Error</div> -->
														</div>
													</div>
													<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
														<div class="data-inner">
															<label for="provinsi-1">No. Urut Keluarga</label>
															<input id="nik" type="text" name="nik" value="{{ (array_key_exists('b4_k4',  $peserta[0]->individu) ? $peserta[0]->individu['b4_k4'] : '') }}" readonly>
															<!-- <div class="error">Pesan Error</div> -->
														</div>
													</div>
													<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
														<div class="data-inner">
															<label for="provinsi-1">NIK</label>
															<input id="nik" type="text" name="nik" value="{{ (array_key_exists('nik',  $peserta[0]->individu) ? $peserta[0]->individu['nik'] : '') }}" readonly>
															<!-- <div class="error">Pesan Error</div> -->
														</div>
													</div>
													<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
														<div class="data-inner">
															<label for="provinsi-1">Nama</label>
															<input id="nik" type="text" name="nik" value="{{ (array_key_exists('nama',  $peserta[0]->individu) ? $peserta[0]->individu['nama'] : '') }}" readonly>
															<!-- <div class="error">Pesan Error</div> -->
														</div>
													</div>
													<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
														<div class="data-inner">
															<label for="provinsi-1">Jenis Kelamin</label>
															<input id=jeniskelamin" type="text" name="jeniskelamin" value="{{ (array_key_exists('b4_k6',  $peserta[0]->individu) ? (($peserta[0]->individu['b4_k6'] == '1') ? 'Laki-laki' : 'Perempuan') : '') }}" readonly>
															<!-- <div class="error">Pesan Error</div> -->
														</div>
													</div>
													<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
														<div class="data-inner">
															<label for="provinsi-1">Umur</label>
															<input id="nik" type="text" name="nik" value="{{ (array_key_exists('b4_K7',  $peserta[0]->individu) ? $peserta[0]->individu['b4_k7'] : '') }}" readonly>
															<!-- <div class="error">Pesan Error</div> -->
														</div>
													</div>
												</div>
											</li>
											<li class="mcf-item">
												<table class="uk-table uk-table-hover">
													<thead>
														<tr>
															<th>No.</th>
															<th>Nama Indikator</th>
															<th>Kondisi Sebelum</th>
															<th>Kondisi Sesudah</th>
														</tr>
													</thead>
													<tbody>
														@php($i = 1)
														@foreach($indivar as $listindivar)
														<tr>
															<td>{{$i++}}. </td>
															<td>{{ App\Models\IndikatorVariabel::getvariabel($listindivar->kode_variabel) }}</td>
															<td>
																{{ ($listindivar->caraisi == '1') ? (array_key_exists($listindivar->kode_variabel, $peserta_old[0]->individu) ? $peserta_old[0]->individu[$listindivar->kode_variabel] : '') : App\Models\OpsiIndikator::getopsivar($listindivar->kode_variabel, (array_key_exists($listindivar->kode_variabel, $peserta_old[0]->individu) ? $peserta_old[0]->individu[$listindivar->kode_variabel] : '')) }}
															</td>
															<td>
																{{ ($listindivar->caraisi == '1') ? (array_key_exists($listindivar->kode_variabel, $peserta[0]->individu) ? $peserta[0]->individu[$listindivar->kode_variabel] : '') : App\Models\OpsiIndikator::getopsivar($listindivar->kode_variabel, (array_key_exists($listindivar->kode_variabel, $peserta[0]->individu) ? $peserta[0]->individu[$listindivar->kode_variabel] : '')) }}
															</td>
														</tr>
														@endforeach
													</tbody>
												</table>
											</li>
										</ul>
										
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
