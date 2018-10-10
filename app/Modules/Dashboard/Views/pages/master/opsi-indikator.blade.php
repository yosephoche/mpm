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
			<h2>Opsi Indikator</h2>
		</div>
	</div>
	<div class="mc-breadcrumb" data-uk-sticky="{top:60}">
		<ul class="uk-breadcrumb">
			<li><a href="{{ URL('/dashboard') }}">Dashboard</a></li>
			<li><a href="{{ URL('/master/indikator/opsi') }}">Daftar Opsi Indikator</a></li>
			<li><a href="javascript:;">Opsi Indikator</a></li>
		</ul>
	</div>
	<div class="mc-form">
		<div class="mc-form-wrapper">
			<div class="mc-form-inner">
				<form id="form_indikator_opsi" action="" method="post" class="uk-form"  novalidate="novalidate">
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<div class="mcf-content">
						<div class="mcf-title">
							<h3>Opsi Indikator</h3>
						</div>
						<ul class="mcf-list">
							<li class="mcf-item">
								<div class="data uk-grid">
									<!-- <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<div>
												<label for="sub-opsi">Sub Opsi Indikator</label>
											</div>
											<div class="uk-button uk-form-select uk-active" data-uk-form-select>
												<span class="">Sub Opsi Indikator</span>
			                                    <i class="uk-icon-angle-down uk-icon-medium"></i>
			                                    <select id="sub-opsi" name="sub-opsi">
			                                        <option value="">Pilih Sub Opsi Indikator</option>
													<option value="1">Ya</option>
                                                    <option value="2">Tidak</option>
			                                    </select>
											</div>
											<div class="error" id="sub-opsi_err"></div>
										</div>
									</div> -->
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<div>
												<label for="nama-variabel">Nama Variabel</label>
											</div>
											<div class="uk-button uk-form-select uk-active" data-uk-form-select>
												<span class="">Nama Variabel</span>
			                                    <i class="uk-icon-angle-down uk-icon-medium"></i>
			                                    <select id="nama-variabel" name="nama-variabel">
			                                        <option value="">Pilih Nama Variabel</option>
                                                    @foreach($indi as $listindi)
                                                        <option value="{{ $listindi->kode_variabel }}">{{ $listindi->nama }}</option>
                                                    @endforeach
			                                    </select>
											</div>
											<div class="error" id="nama-variabel_err"></div>
										</div>
									</div>
									<!-- <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 uk-hidden">
										<div class="data-inner">
											<label for="nama-sub">Kode Sub Variabel</label>
											<input id="kode-sub" type="text" name="kode-sub">
											<div class="error" id="kode-sub_err"></div>
										</div>
									</div>
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 uk-hidden">
										<div class="data-inner">
											<label for="nama-sub">Nama Sub Variabel</label>
											<input id="nama-sub" type="text" name="nama-sub">
											<div class="error" id="nama-sub_err"></div>
										</div>
									</div> -->
									<!-- <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 uk-hidden">
										<div class="data-inner">
											<div>
												<label for="opsi-indi">Opsi Indikator</label>
											</div>
											<div class="uk-button uk-form-select uk-active" data-uk-form-select>
												<span class="">Opsi Indikator</span>
			                                    <i class="uk-icon-angle-down uk-icon-medium"></i>
			                                    <select id="opsi-indi" name="opsi-indi">
			                                        <option value="">Pilih Opsi Indikator</option>
			                                    </select>
											</div>
											<div class="error" id="nama-variabel_err"></div>
										</div>
									</div> -->
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<label for="no-opsi">No. Opsi</label>
											<input id="no-opsi" type="text" name="no-opsi">
											<div class="error" id="no-opsi_err"></div>
										</div>
									</div>
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<label for="no-opsi">Opsi Indikator</label>
											<input id="desc-opsi" type="text" name="desc-opsi">
											<div class="error" id="desc-opsi_err"></div>
										</div>
									</div>
									<!-- <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<div>
												<label for="rincian">Rincian Jawaban</label>
											</div>
											<div class="uk-button uk-form-select uk-active" data-uk-form-select>
												<span class="">Rincian Jawaban</span>
			                                    <i class="uk-icon-angle-down uk-icon-medium"></i>
			                                    <select id="rincian" name="rincian">
													<option value="1">Ya</option>
			                                        <option value="2" selected>Tidak</option>
			                                    </select>
											</div>
											<div class="error" id="rincian_err"></div>
										</div>
									</div> -->
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
											<button name="submit" id="submit-save" type="submit">Simpan</button>
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
	var sidebar = 'indi-opsi';
</script>

<script src="{{ URL('/assets/js/backend/indikator.js') }}"></script>
@stop
