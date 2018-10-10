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
			<h2>Sunting Indikator Variabel</h2>
		</div>
	</div>
	<div class="mc-breadcrumb" data-uk-sticky="{top:60}">
		<ul class="uk-breadcrumb">
			<li><a href="{{ URL('/dashboard') }}">Dashboard</a></li>
			<li><a href="{{ URL('/master/indikator/variabel') }}">Daftar Indikator Variabel</a></li>
			<li><a href="javascript:;">Sunting Indikator Variabel</a></li>
		</ul>
	</div>
	<div class="mc-form">
		<div class="mc-form-wrapper">
			<div class="mc-form-inner">
				<form id="form_indi_var_update" action="" method="post" class="uk-form"  novalidate="novalidate">
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<div class="mcf-content">
						<div class="mcf-title">
							<h3>Sunting Indikator Variabel</h3>
						</div>
						<ul class="mcf-list">
							<li class="mcf-item">
								<div class="data uk-grid">
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<div>
												<label for="tingkat-variabel">Tingkat</label>
											</div>
											<div class="uk-button uk-form-select uk-active" data-uk-form-select>
												<span class="">Tingkat</span>
			                                    <i class="uk-icon-angle-down uk-icon-medium"></i>
			                                    <select id="tingkat-variabel" name="tingkat-variabel">
			                                        <option value="">Pilih Tingkat</option>
													<option value="1" {{ ($indi[0]->tingkat == 1) ? 'selected' : '' }} >Individu</option>
													<option value="2" {{ ($indi[0]->tingkat == 2) ? 'selected' : '' }}>Rumah Tangga</option>
													<option value="3" {{ ($indi[0]->tingkat == 3) ? 'selected' : '' }}>Asset</option>
			                                    </select>
											</div>
											<div class="error" id="tingkat-variabel_err"></div>
										</div>
									</div>
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<label for="kode-variabel">Kode Variabel</label>
											<input id="kode-variabel" type="text" name="kode-variabel" value="{{ $indi[0]->kode_variabel }}">
											<div class="error" id="nama-variabel_err"></div>
										</div>
									</div>
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<label for="nama-variabel">Nama Variabel</label>
											<input id="nama-variabel" type="text" name="nama-variabel" value="{{ $indi[0]->nama }}">
											<div class="error" id="nama-variabel_err"></div>
										</div>
									</div>
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<div>
												<label for="cara-isi">Cara isi</label>
											</div>
											<div class="uk-button uk-form-select uk-active" data-uk-form-select>
												<span class="">Cara Isi</span>
			                                    <i class="uk-icon-angle-down uk-icon-medium"></i>
			                                    <select id="cara-isi" name="cara-isi">
			                                        <option value="">Pilih Cara Isi</option>
													<option value="1" {{ ($indi[0]->caraisi == 1) ? 'selected' : '' }}>Isi</option>
													<option value="2" {{ ($indi[0]->caraisi == 2) ? 'selected' : '' }}>Pilih</option>
													<option value="3" {{ ($indi[0]->caraisi == 3) ? 'selected' : '' }}>Cek</option>
			                                    </select>
											</div>
											<div class="error" id="cara-isi_err"></div>
										</div>
									</div>
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<label for="ket-satuan">Keterangan Satuan</label>
											<input id="ket-satuan" type="text" name="ket-satuan" value="{{ $indi[0]->ketsatuan }}">
											<div class="error" id="ket-satuan_err"></div>
										</div>
									</div>
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<div>
												<label for="pendaftaran">Pendaftaran</label>
											</div>
											<div class="uk-button uk-form-select uk-active" data-uk-form-select>
												<span class="">Pendaftaran</span>
												<i class="uk-icon-angle-down uk-icon-medium"></i>
												<select id="pendaftaran" name="pendaftaran">
													<option value="1" {{ ($indi[0]->pendaftaran == '1') ? 'selected' : '' }}>Aktif</option>
													<option value="2" {{ ($indi[0]->pendaftaran == '2') ? 'selected' : '' }}>Tidak Aktif</option>
												</select>
											</div>
											<div class="error" id="tingkat-variabel_err"></div>
										</div>
									</div>
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<div>
												<label for="verifikasi">Verifikasi</label>
											</div>
											<div class="uk-button uk-form-select uk-active" data-uk-form-select>
												<span class="">Verifikasi</span>
												<i class="uk-icon-angle-down uk-icon-medium"></i>
												<select id="verifikasi" name="verifikasi">
													<option value="1" {{ ($indi[0]->verifikasi == '1') ? 'selected' : '' }}>Aktif</option>
													<option value="2" {{ ($indi[0]->verifikasi == '2') ? 'selected' : '' }}>Tidak Aktif</option>
												</select>
											</div>
											<div class="error" id="tingkat-variabel_err"></div>
										</div>
									</div>
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<div>
												<label for="verifikasi">Jenis Indikator</label>
											</div>
											<div class="uk-button uk-form-select uk-active" data-uk-form-select>
												<span class="">verifikasi</span>
												<i class="uk-icon-angle-down uk-icon-medium"></i>
												<select id="jenisindikator" name="jenisindikator">
													<option value="1" {{ ($indi[0]->jenisindikator == '1') ? 'selected' : '' }}>Nasional</option>
													<option value="2" {{ ($indi[0]->jenisindikator == '2') ? 'selected' : '' }}>Lokal</option>
												</select>
											</div>
											<div class="error" id="verifikasi_err"></div>
										</div>
									</div>
								</div>
							</li>
                            <li class="mcf-item">
                                <div id="alert" class="uk-alert uk-alert-large uk-hidden" data-uk-alert>
                                    <p></p>
                                </div>
                            </li>
							<li class="mcf-item">
								<div class="submit">
									<div class="uk-clearfix">
										<div class="uk-float-right">
											<button name="submit" id="submit-save" data-id="{{ $indi[0]->_id }}" type="submit">Simpan</button>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	var sidebar = 'indi-var';
</script>

<script src="{{ URL('/assets/js/backend/indikator.js') }}"></script>
@stop
