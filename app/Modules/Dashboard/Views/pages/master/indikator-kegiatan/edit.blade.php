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
			<li><a href="{{ URL('/master/jenis-kegiatan') }}">Daftar Jenis Kegiatan</a></li>
			<li><a href="javascript:;">{{ $title }}</a></li>
		</ul>
	</div>
	<div class="mc-form">
		<div class="mc-form-wrapper">
			<div class="mc-form-inner">
				<form id="form_master_indikator_kegiatan_update" action="" method="post" class="uk-form"  novalidate="novalidate">
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
											<label for="name_jenis_kegiatan">Nama Jenis Kegiatan</label>
                                            <input id="name_jenis_kegiatan" type="text" name="name_jenis_kegiatan" value="{{$kegiatan->kategori_name}}" required>
											<div class="error" id="name_jenis_kegiatan_err"></div>
										</div>
									</div>
								</div>
							</li>
							<li class="mcf-item">
								<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
									<div class="data-inner uk-text-left">
										<div class="checkbox">

											@foreach($indikator as $item)
											<div>
												<input data-status="rt" value="{{ $item->nama }}" id="{{ $item->kode_variabel }}" type="checkbox" name="{{ $item->kode_variabel }}" 
													@if (!empty($kegiatan->datavariable))
														@foreach ($kegiatan->datavariable[0] as $key => $itemIndikator)
															{{ ($itemIndikator == $item->nama) ? 'checked' : '' }}
														@endforeach
													@endif
												>
												<label for="{{ $item->kode_variabel }}">{{ $item->nama }}</label>
											</div>
											@endforeach
										</div>
										<div class="error" id="{{ $item->kode_variabel }}_err"></div>
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
											<button name="submit" id="submit-save" data-id="{{ $kegiatan->_id }}" type="submit">Simpan</button>
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
