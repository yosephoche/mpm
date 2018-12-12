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
			<h2>{{ $title }}</h2>
		</div>
	</div>
	<div class="mc-breadcrumb" data-uk-sticky="{top:60}">
		<ul class="uk-breadcrumb">
			<li><a href="{{ URL('/dashboard') }}">Dashboard</a></li>
			<li><a href="{{ URL('/anggaran-kegiatan') }}">Anggaran Kegiatan</a></li>
			<li><a href="javascript:;">{{ $title }}</a></li>
		</ul>
	</div>
	<div class="mc-form">
		<div class="mc-form-wrapper">
			<div class="mc-form-inner">
				<form id="form_anggaran_kegiatan_opd_update" action="" method="post" class="uk-form"  novalidate="novalidate">
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<div class="mcf-content">
						<div class="mcf-title">
							<h3>{{ $title }}</h3>
						</div>
						<ul class="mcf-list">
							<li class="mcf-item">
								<div class="data uk-grid">
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<div>
												<label for="anggaran_jenis_kegiatan">Jenis Kegiatan</label>
											</div>
											<div class="uk-button uk-form-select uk-active" data-uk-form-select>
												<span class="">Jenis Kegiatan</span>
												<i class="uk-icon-angle-down uk-icon-medium"></i>
												<select id="anggaran_jenis_kegiatan" name="anggaran_jenis_kegiatan">
													<option value="">Pilih Jenis Kegiatan</option>
													@foreach($jenis as $thisJenis)
														@if ($thisJenis->name != null)
															<option value="{{ $thisJenis->_id }}" {{ ($thisJenis->_id == $anggaran->anggaran_jenis_kegiatan) ? 'selected' : ''}}>{{ $thisJenis->name }}</option>
														@endif
													@endforeach
												</select>
											</div>
											<div class="error" id="anggaran_jenis_kegiatan_err"></div>
										</div>
									</div>
								</div>
							</li>
							<li class="mcf-item">
								<div class="data uk-grid">
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<label for="anggaran_nama_kegiatan">Nama Kegiatan</label>
											<input id="anggaran_nama_kegiatan" type="text" name="anggaran_nama_kegiatan" value="{{ $anggaran->anggaran_nama_kegiatan }}" required>
											<div class="error" id="anggaran_nama_kegiatan_err"></div>
										</div>
									</div>
								</div>
							</li>
							<li class="mcf-item">
								<div class="data uk-grid">
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<label for="anggaran_besaran">Nilai Anggaran Kegiatan</label>
											<input id="anggaran_besaran" type="text" name="anggaran_besaran" value="{{ $anggaran->anggaran_besaran }}" required>
											<div class="error" id="anggaran_besaran_err"></div>
										</div>
									</div>
								</div>
							</li>
							<li class="mcf-item">
								<div class="data uk-grid">
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<label for="anggaran_tahun_kegiatan">Tahun Anggaran Kegiatan</label>
											<input id="anggaran_tahun_kegiatan" type="text" name="anggaran_tahun_kegiatan" value="{{ $anggaran->anggaran_tahun_kegiatan }}" required>
											<div class="error" id="anggaran_tahun_kegiatan_err"></div>
										</div>
									</div>
								</div>
							</li>
                            <li class="mcf-item">
                                <div id="alert-indi-var" class="uk-alert uk-alert-large uk-hidden" data-uk-alert>
                                    <p></p>
                                </div>
                            </li>
							<li class="mcf-item">
								<div class="submit">
									<div class="uk-clearfix">
										<div class="uk-float-right">
											<button name="submit" id="submit-save" data-id="{{ $anggaran->_id }}" type="submit">Simpan</button>
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

<script src="{{ URL('/assets/js/backend/anggaran-kegiatan.js') }}"></script>
@stop
