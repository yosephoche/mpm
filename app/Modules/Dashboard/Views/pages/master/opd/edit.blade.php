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
			<li><a href="{{ URL('/master/indikator/variabel') }}">Daftar Indikator Variabel</a></li>
			<li><a href="javascript:;">{{ $title }}</a></li>
		</ul>
	</div>
	<div class="mc-form">
		<div class="mc-form-wrapper">
			<div class="mc-form-inner">
				<form id="form_master_opd_update" action="" method="post" class="uk-form"  novalidate="novalidate">
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
											<label for="name_opd">Nama OPD</label>
                                            <input id="name_opd" type="text" name="name_opd" value="{{$skpd->name}}" required>
											<div class="error" id="name_opd_err"></div>
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
											<button name="submit" id="submit-save" data-id="{{ $skpd->_id }}" type="submit">Simpan</button>
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
