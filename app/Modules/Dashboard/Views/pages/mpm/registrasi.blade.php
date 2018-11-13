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
			<h2>Pendaftaran MPM</h2>
		</div>
	</div>
	<div class="mc-breadcrumb" data-uk-sticky="{top:60}">
        <ul class="uk-breadcrumb">
            <li><a href="javascript:;">Pendaftaran</a></li>
			<li><a href="{{ URL('/mpm') }}">Daftar Peserta MPM</a></li>
            <li><a href="javascript:;">Pendaftaran Peserta MPM</a></li>
        </ul>
    </div>

	<div class="mc-form">
		<div class="mc-form-wrapper">
			<div class="mc-form-inner">
				<form id="form-pendaftaran-mpm" action="" method="post" class="uk-form"  novalidate="novalidate">
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<div class="mcf-content">
						<div class="mcf-title">
							<h3>Formulir Pendaftaran Rumah Tangga Miskin & Kurang Mampu</h3>
						</div>
						<ul class="mcf-list">
							<li class="mcf-item">
								<div class="title">
									<h4>Informasi Pendaftar</h4>
								</div>
								<div class="data uk-grid">
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<label for="nomorKk">Nomor Kartu Keluarga</label>
											<input id="nomorKk" type="text" name="nomorKk" maxlength="16">
											<div class="error" id="nomorKk_err"></div>
										</div>
									</div>
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<label for="nik">NIK (Nomor Induk Kependudukan)</label>
											<!-- <button>Cek NIK</button> -->
											<input id="nik" type="text" name="nik" maxlength="16">
											<div class="error" id="nik_err"></div>
										</div>
									</div>
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<label for="namaLengkap">Nama Lengkap (Sesuai KTP)</label>
											<input id="namaLengkap" type="text" name="namaLengkap">
											<div class="error" id="namaLengkap_err"></div>
										</div>
									</div>

									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<div>
												<label for="jenisKelamin">Jenis Kelamin</label>
											</div>
											<div class="uk-button uk-form-select uk-active" data-uk-form-select>
												<span class="">Laki-Laki</span>
			                                    <i class="uk-icon-angle-down uk-icon-medium"></i>
			                                    <select id="jenisKelamin" name="jenisKelamin">
			                                        <option value="1">Laki-Laki</option>
			                                        <option value="2">Perempuan</option>
			                                    </select>
											</div>
											<div class="error" id="jenisKelamin_err"></div>
										</div>
									</div>
									
									@php($hubkk = App\Models\IndikatorVariabel::getIndikatorVar('b4_k5'))
									@if($hubkk)
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<div>
												<label for="indi-{{ $hubkk->kode }}">{{ $hubkk->nama }}</label>
											</div>
											<div class="uk-button uk-form-select uk-active" data-uk-form-select>
												<span class="">Pilih {{ $hubkk->nama }}</span>
												<i class="uk-icon-angle-down uk-icon-medium"></i>
												<select id="{{ $hubkk->kode_variabel }}" name="{{ $hubkk->kode }}">
													<option value="">Pilih {{ $hubkk->nama }}</option>
													@foreach(App\Models\OpsiIndikator::getopsi($hubkk->kode_variabel) as $listopsi)
													<option value="{{ $listopsi->no_opsi }}">{{ $listopsi->no_opsi.'. '.$listopsi->desc_opsi }}</option>
													@endforeach
												</select>
											</div>
											<div class="error" id="{{ $hubkk->kode }}_err"></div>
										</div>
									</div>
									@endif

									@php($hubrt = App\Models\IndikatorVariabel::getIndikatorVar('b4_k3'))
									@if($hubrt)
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<div>
												<label for="indi-{{ $hubrt->kode }}">{{ $hubrt->nama }}</label>
											</div>
											<div class="uk-button uk-form-select uk-active" data-uk-form-select>
												<span class="">Pilih {{ $hubrt->nama }}</span>
												<i class="uk-icon-angle-down uk-icon-medium"></i>
												<select id="{{ $hubrt->kode_variabel }}" name="{{ $hubrt->kode }}">
													<option value="">Pilih {{ $hubrt->nama }}</option>
													@foreach(App\Models\OpsiIndikator::getopsi($hubrt->kode_variabel) as $listopsi)
													<option value="{{ $listopsi->no_opsi }}">{{ $listopsi->no_opsi.'. '.$listopsi->desc_opsi }}</option>
													@endforeach
												</select>
											</div>
											<div class="error" id="{{ $hubrt->kode }}_err"></div>
										</div>
									</div>
									@endif

								</div>
							</li>
							<li class="mcf-item">
								<div class="title">
									<h4>Informasi Rumah Tangga</h4>
								</div>
								<div class="data uk-grid">									
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<label for="nikKepRt">NIK Kepala Rumah Tangga</label>
											<input id="nikKepRt" type="text" name="nikKepRt" maxlength="16">
											<div class="error" id="nikKepRt_err"></div>
										</div>
									</div>
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<label for="namaKepRt">Nama Kepala Rumah Tangga</label>
											<input id="namaKepRt" type="text" name="namaKepRt">
											<div class="error" id="namaKepRt_err"></div>
										</div>
									</div>
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<div>
												<label for="jenisKelKepRt">Jenis Kelamin</label>
											</div>
											<div class="uk-button uk-form-select uk-active" data-uk-form-select>
												<span class="">Laki-Laki</span>
			                                    <i class="uk-icon-angle-down uk-icon-medium"></i>
			                                    <select id="jenisKelKepRt" name="jenisKelKepRt">
			                                        <option value="1">Laki-Laki</option>
			                                        <option value="2">Perempuan</option>
			                                    </select>
											</div>
											<div class="error" id="jenisKelKepRt_err"></div>
										</div>
									</div>
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<label for="ttlKepRt">Umur</label>
											<input id="umur" type="text" name="umur">
											<div class="error" id="umur_err"></div>
										</div>
									</div>
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<div>
												<label for="pekerjaanKepRt">Status Pekerjaan Kepala Rumah Tangga</label>
											</div>
											<div class="uk-button uk-form-select uk-active" data-uk-form-select>
												<span class="">Bekerja</span>
			                                    <i class="uk-icon-angle-down uk-icon-medium"></i>
			                                    <select id="pekerjaanKepRt" name="pekerjaanKepRt">
			                                        <option value="">Pilih Status</option>
			                                        <option value="1">1. Bekerja</option>
			                                        <option value="2">2. Tidak Bekerja</option>
			                                    </select>
											</div>
											<div class="error" id="pekerjaanKepRt_err"></div>
										</div>
									</div>
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<label for="jumAngKel">Jumlah Anggota Keluarga</label>
											<input id="jumAngKel" type="text" name="jumAngKel">
											<div class="error" id="jumAngKel_err"></div>
										</div>
									</div>
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<label for="namaJalan">Nama Jalan / (RT / RW)</label>
											<input id="namaJalan" type="text" name="namaJalan">
											<div class="error" id="namaJalan_err"></div>
										</div>
									</div>
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<div>
												<label for="kecamatan">Kecamatan</label>
											</div>
											<div class="uk-button uk-form-select uk-active" data-uk-form-select>
												<span class="">Pilih Kecamatan</span>
			                                    <i class="uk-icon-angle-down uk-icon-medium"></i>
			                                    <select id="kecamatan" name="kecamatan">
													<option value="">Pilih Kecamatan</option>
													@foreach($kecamatan as $listkec)
			                                        <option value="{{ $listkec->id_kecamatan }}">{{ $listkec->kecamatan }}</option>
													@endforeach
			                                    </select>
											</div>
											<div class="error" id="kecamatan_err"></div>
										</div>
									</div>
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<div>
												<label for="kelurahan">Kelurahan</label>
											</div>
											<div class="uk-button uk-form-select uk-active" data-uk-form-select>
												<span class="">Pilih Kelurahan</span>
			                                    <i class="uk-icon-angle-down uk-icon-medium"></i>
			                                    <select id="kelurahan" name="kelurahan">
			                                        <option value="">Pilih Kelurahan</option>
			                                    </select>
											</div>
											<div class="error" id="kelurahan_err"></div>
										</div>
									</div>
								</div>
							</li>
							<li class="mcf-item">
								<div class="title">
									<h4>Informasi Bangunan Tempat Tinggal</h4>
								</div>
								<div class="data uk-grid">
									@foreach($indivarrt as $listindirt)
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner uk-text-left">
											<label for="">{{ $listindirt->nama }}</label>
											<div class="checkbox">
												@foreach(App\Models\OpsiIndikator::getopsi($listindirt->kode_variabel) as $listopsirt)
													<div><input id="{{ $listopsirt->kode_variabel.'_'.$listopsirt->no_opsi }}" data-status="rt" value="{{ $listopsirt->no_opsi }}" type="radio" name="{{ $listindirt->kode_variabel }}"><label for="{{ $listopsirt->kode_variabel.'_'.$listopsirt->no_opsi }}">{{ $listopsirt->no_opsi.'. '.$listopsirt->desc_opsi }}</label></div>
												@endforeach
											</div>
											<div class="error" id="{{ $listindirt->kode_variabel }}_err"></div>
										</div>
									</div>
									@endforeach


									@foreach($indivarasset as $listindiasset)
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner uk-text-left">
											<label for="">{{ $listindiasset->nama }}</label>
											<div class="checkbox">
												@foreach(App\Models\OpsiIndikator::getopsi($listindiasset->kode_variabel) as $listopsiasset)
													<div><input id="{{ $listopsiasset->kode_variabel.'_'.$listopsiasset->no_opsi }}" data-status="asset" value="{{ $listopsiasset->no_opsi }}" type="radio" name="{{ $listindiasset->kode_variabel }}"><label for="{{ $listopsiasset->kode_variabel.'_'.$listopsiasset->no_opsi }}">{{ $listopsiasset->no_opsi.'. '.$listopsiasset->desc_opsi }}</label></div>
												@endforeach
											</div>
											<div class="error" id="{{ $listindiasset->kode_variabel }}_err"></div>
										</div>
									</div>
									@endforeach

									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner uk-text-left">
											<label for="">Pendidikan tertinggi ART yang tidak bersekolah</label>
											<div class="checkbox">
												@foreach(App\Models\OpsiIndikator::getopsi('b4_k18') as $listopsipd)
													<div><input id="{{ 'pendidikanart_'.$listopsipd->no_opsi }}" value="{{ $listopsipd->no_opsi }}" type="radio" name="pendidikanart"><label for="{{ 'pendidikanart_'.$listopsipd->no_opsi }}">{{ $listopsipd->no_opsi.'. '.$listopsipd->desc_opsi }}</label></div>
												@endforeach
											</div>
											<div class="error" id="pendidikanart_err"></div>
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
<div id="modal-sudah-registrasi" class="uk-modal">
    <div class="uk-modal-dialog">
        <div class="uk-modal-header">
            <div class="uk-clearfix">
                <div class="uk-float-left">
                    <h3>Peringatan!</h3>
                </div>
                <div class="uk-float-right">
                    <button class="uk-modal-close uk-close"></button>
                </div>
            </div>
        </div>
        <div class="modal-content">
            <p></p>
        </div>
        <div class="uk-modal-footer">
            <ul>
                <li><button class="button-blue uk-modal-close" >OK</button></li>
            </ul>
        </div>
    </div>
</div>
<script>
	var sidebar = 'pendaftaran-mpm';
</script>

<script src="{{ URL('/assets/js/backend/mpm.js') }}"></script>
@stop
