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
															<label for="provinsi-1">No. Urut Rumah Tangga</label>
															<input id="nik" type="text" name="nik" value="{{ empty($peserta->nourut_rt) ? '' : $peserta->nourut_rt }}" readonly>
															<!-- <div class="error">Pesan Error</div> -->
														</div>
													</div>
													<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
														<div class="data-inner">
															<label for="provinsi-1">Kecamatan</label>
															<input id="nik" type="text" name="nik" value="{{ App\Models\Kecamatan::getkecamatan($peserta->kec) }}" readonly>
															<!-- <div class="error">Pesan Error</div> -->
														</div>
													</div>
													<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
														<div class="data-inner">
															<label for="provinsi-1">Kelurahan</label>
															<input id="nik" type="text" name="nik" value="{{ App\Models\Kelurahan::getkelurahan($peserta->des) }}" readonly>
															<!-- <div class="error">Pesan Error</div> -->
														</div>
													</div>
													<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
														<div class="data-inner">
															<label for="provinsi-1">Alamat</label>
															<input id="nik" type="text" name="nik" value="{{ $peserta->b1_k6 }}" readonly>
															<!-- <div class="error">Pesan Error</div> -->
														</div>
													</div>
													<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
														<div class="data-inner">
															<label for="provinsi-1">No. Kartu Keluarga</label>
															<input id="nik" type="text" name="nik" value="{{ $peserta->nokk }}" readonly>
															<!-- <div class="error">Pesan Error</div> -->
														</div>
													</div>
													<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
														<div class="data-inner">
															<label for="provinsi-1">Nama Kepala Rumah Tangga</label>
															<input id="nik" type="text" name="nik" value="{{ ((App\Models\PesertaBDT::getkrt($peserta->kodepeserta)) ? App\Models\PesertaBDT::getkrt($peserta->kodepeserta)[0]['nama'] : '') }}" readonly>
															<!-- <div class="error">Pesan Error</div> -->
														</div>
													</div>
													<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
														<div class="data-inner">
															<label for="provinsi-1">Jumlah ART</label>
															<input id="nik" type="text" name="nik" value="{{ $peserta->b1_k9 }}" readonly>
															<!-- <div class="error">Pesan Error</div> -->
														</div>
													</div>
													<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
														<div class="data-inner">
															<label for="provinsi-1">Jumlah Keluarga</label>
															<input id="nik" type="text" name="nik" value="{{ $peserta->b1_k10 }}" readonly>
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
														@foreach($indivarrt as $listindivar)
														<tr>
															<td>{{$i++}}. </td>
															<td>{{ App\Models\IndikatorVariabel::getvariabel($listindivar->kode_variabel) }}</td>
															<td>
																{{ ($listindivar->caraisi == '1') ? (array_key_exists($listindivar->kode_variabel, $peserta_old->datart[0]) ? $peserta_old->datart[0][$listindivar->kode_variabel] : '') : App\Models\OpsiIndikator::getopsivar($listindivar->kode_variabel, (array_key_exists($listindivar->kode_variabel, $peserta_old->datart[0]) ? $peserta_old->datart[0][$listindivar->kode_variabel] : '')) }}
															</td>
															<td>
																{{ ($listindivar->caraisi == '1') ? (array_key_exists($listindivar->kode_variabel, $peserta->datart[0]) ? $peserta->datart[0][$listindivar->kode_variabel] : '') : App\Models\OpsiIndikator::getopsivar($listindivar->kode_variabel, (array_key_exists($listindivar->kode_variabel, $peserta->datart[0]) ? $peserta->datart[0][$listindivar->kode_variabel] : '')) }}
															</td>
														</tr>
														@endforeach
														@foreach($indivarasset as $listindiasset)
														<tr>
															<td>{{$i++}}. </td>
															<td>{{ App\Models\IndikatorVariabel::getvariabel($listindiasset->kode_variabel) }}</td>
															<td>
																{{ ($listindivar->caraisi == '1') ? (array_key_exists($listindiasset->kode_variabel, $peserta_old->asset[0]) ? $peserta_old->asset[0][$listindiasset->kode_variabel] : '') : App\Models\OpsiIndikator::getopsivar($listindiasset->kode_variabel, (array_key_exists($listindiasset->kode_variabel, $peserta_old->asset[0]) ? $peserta_old->asset[0][$listindiasset->kode_variabel] : '')) }}
															</td>
															<td>
																{{ ($listindiasset->caraisi == '1') ? (array_key_exists($listindiasset->kode_variabel, $peserta->asset[0]) ? $peserta->asset[0][$listindiasset->kode_variabel] : '') : App\Models\OpsiIndikator::getopsivar($listindiasset->kode_variabel, (array_key_exists($listindiasset->kode_variabel, $peserta->asset[0]) ? $peserta->asset[0][$listindiasset->kode_variabel] : '')) }}
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
	var sidebar = 'sidebar-finduk-rt';
</script>
<script type="text/javascript" src="{{ url('/assets/js/jquery.printPage.js') }}"></script>
<script src="{{ URL('/assets/js/backend/induk.js') }}"></script>
@stop
