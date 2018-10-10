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
			<h2>Registrasi Pengguna</h2>
		</div>
	</div>
	<div class="mc-breadcrumb" data-uk-sticky="{top:60}">
        <ul class="uk-breadcrumb">
            <li><a href="{{ URL('/dashboard') }}">Dashboard</a></li>
			<li><a href="{{ URL('/pengguna') }}">Daftar Pengguna</a></li>
            <li><a href="javascript:;">Registrasi Pengguna</a></li>
        </ul>
    </div>

	<div class="mc-form">
		<div class="mc-form-wrapper">
			<div class="mc-form-inner">
				<form id="registrasi-user" action="" method="post" class="uk-form"  novalidate="novalidate">
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

					<div class="mcf-content">
						<div class="mcf-title">
							<h3>Formulir Registrasi Pengguna MPM</h3>
						</div>
						<ul class="mcf-list">
							<li class="mcf-item">
								<div class="data uk-grid">
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<label for="nama_lengkap">Nama Lengkap</label>
											<input id="nama_lengkap" type="text" name="nama_lengkap">
											<div class="error" id="nama_lengkap_err"></div>
										</div>
									</div>
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<label for="email">Email</label>
											<input id="email" type="email" name="email">
											<div class="error" id="email_err"></div>
										</div>
									</div>
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="password">Kata Sandi</label>
                                            <input id="password" type="password" name="password">
                                            <div class="error" id="password_err"></div>
                                        </div>
                                    </div>
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="kontak">Kontak</label>
                                            <input id="kontak" type="text" name="kontak">
                                            <div class="error" id="kontak_err"></div>
                                        </div>
                                    </div>
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<div>
												<label for="status_admin">Status</label>
											</div>
											<div class="uk-button uk-form-select uk-active" data-uk-form-select>
												<span class="">Status</span>
			                                    <i class="uk-icon-angle-down uk-icon-medium"></i>
			                                    <select id="status_admin" name="status_admin">
			                                        <option value="">Pilih Status</option>
                                                    @foreach($userstatus as $us)
														@if((auth()->guard('admin')->user()->status_admin !== '0') && ($us->kode == '0'))

			                            	            @else
			                            	            <option value="{{ $us->kode }}">{{ $us->name }}</option>
			                            	            @endif
                                                    @endforeach
			                                    </select>
											</div>
											<div class="error" id="status_admin_err"></div>
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

<script>
	var sidebar = 'registrasi-user';
</script>

<script src="{{ URL('/assets/js/backend/registrasi.js') }}"></script>
@stop
