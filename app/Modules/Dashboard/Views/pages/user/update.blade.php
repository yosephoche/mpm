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
			<h2>Sunting Pengguna</h2>
		</div>
	</div>
	<div class="mc-breadcrumb" data-uk-sticky="{top:60}">
        <ul class="uk-breadcrumb">
            <li><a href="{{ URL('/dashboard') }}">Dashboard</a></li>
			<li><a href="{{ URL('/pengguna') }}">Daftar Pengguna</a></li>
            <li><a href="javascript:;">Sunting Pengguna</a></li>
        </ul>
    </div>

	<div class="mc-form">
		<div class="mc-form-wrapper">
			<div class="mc-form-inner">
				<form id="update-user" action="" method="post" class="uk-form"  novalidate="novalidate">
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

					<div class="mcf-content">
						<div class="mcf-title">
							<h3>Formulir Sunting Pengguna MPM</h3>
						</div>
						<ul class="mcf-list">
							<li class="mcf-item">
								<div class="data uk-grid">
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<label for="nama_lengkap">Nama Lengkap</label>
											<input id="nama_lengkap" type="text" name="nama_lengkap" value="{{ $users[0]->fullname }}">
											<div class="error" id="nama_lengkap_err"></div>
										</div>
									</div>
									<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
										<div class="data-inner">
											<label for="email">Email</label>
											<input id="email" type="email" name="email" value="{{ $users[0]->email }}">
											<div class="error" id="email_err"></div>
										</div>
									</div>
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="password">Kata Sandi</label>
                                            <div style="margin-top: 16px;"><a id="modal-pass" href="#modal-reset" style="color: #ff1b5f;" data-uk-modal>Reset sandi</a></div>

                                        </div>
                                    </div>
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="kontak">Kontak</label>
                                            <input id="kontak" type="text" name="kontak" value="{{ $users[0]->kontak }}">
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
				                                        <option value="{{ $us->kode }}" {{ ($us->kode == $users[0]->status_admin) ? 'selected' : '' }}>{{ $us->name }}</option>
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
											<button name="submit" id="submit-update" data-id="{{ $users[0]->_id }}" type="submit">Simpan</button>
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

<div id="modal-reset" class="uk-modal">
    <div class="uk-modal-dialog">
		<form class="" action="" id="update-password" method="post"  class="uk-form"  novalidate="novalidate">
	        <div class="uk-modal-header"><h3>Reset kata sandi</h3></div>
	        <div class="uk-modal-body" style="padding: 14px;">
				<div class="uk-width-large-1-1 uk-width-medium-1-1 uk-width-small-1-1">
					<div class="data-inner">
						<label for="password">Kata Sandi</label>
						<input id="password" type="password" style="width:100%" name="password">
						<div style="color: #ff1b5f;"  class="error" id="password_err"></div>
					</div>
				</div>
				<div class="uk-width-large-1-1 uk-width-medium-1-1 uk-width-small-1-1">
					<div class="data-inner">
						<label for="repeat-password">Ulangi Kata Sandi</label>
						<input id="repeat-password" style="width:100%" type="password" name="repeat-password">
						<div style="color: #ff1b5f;"  class="error" id="repeat-password_err"></div>
					</div>
				</div>
	        </div>
			<div id="alert-modal" class="uk-alert uk-alert-large uk-hidden" data-uk-alert>
	            <p></p>
	        </div>
	        <div class="uk-modal-footer">
				<div class="submit">
					<div class="uk-clearfix">
						<div class="uk-float-right">
							<button id="submit-update-pass" data-id="{{ $users[0]->_id }}" type="submit">Simpan</button>
						</div>
					</div>
				</div>
	        </div>
		</form>
    </div>
</div>

<script>
	var sidebar = 'pendaftaran-mpm';
</script>

<script src="{{ URL('/assets/js/backend/registrasi.js') }}"></script>
@stop
