@extends('UserManagement::layouts.main')

@section('content')
<div class="main-login" data-src="/assets/img/login_bg.png">
		<div class="ml-wrapper">
			<div class="ml-inner">
				<div class="uk-clearfix">
					<div class="left uk-float-left uk-hidden-small">
						<div class="form-image" data-src="/assets/img/form_img.png"></div>
					</div>
					<div class="right uk-text-center">
						<div class="header" style="padding: 20px 15px;">
							<a href="/"><h3>Si Emas Terpadu</h3></a>
							<p>( Sistem Informasi Pengetasan Kemiskinan Terpadu )</p>
						</div>
						<div action="" class="ml-form">
							<form class="mlf-input" id="form-login" method="post" action="{{ URL('/globallogin') }}">
							<h4>Silakan login untuk mengakses halaman admin.</h4>
								<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
								<div>
									<label for="username">EMAIL</label>
									<div class="input-group  uk-text-center {{ (Session::has('email')) ? 'error' : '' }}">
										<i class="uk-icon-envelope-o"></i>
										<input type="email" value="{{ (Session::has('getemail')) ? Session::get('getemail') : '' }}" placeholder="Masukkan Email" name="email" id="email">
									</div>
									<div style="font-size: 14px;color: red;">{!! (Session::has('email')) ? Session::get('email') : '' !!}</div>
								</div>
								<div>
									<label for="username">KATA SANDI</label>
									<div class="input-group  uk-text-center {{ (Session::has('password')) ? 'error' : '' }}">
										<i class="uk-icon-key"></i>
										<input type="password" placeholder="Masukkan Sandi" name="password" id="password" >
										<button type="submit" class="submit"><i class="uk-icon-arrow-circle-o-right uk-icon-small"></i></button>
									</div>
									<div style="font-size: 14px;color: red;">{!! (Session::has('password')) ? Session::get('password') : '' !!}</div>

								</div>
							</form>
							<form class="mlf-input" id="form-send-email">
								<div id="alert" class="uk-alert uk-alert-small uk-hidden" data-uk-alert>
                                    <p></p>
                                </div>
								<div>
									<label for="username">ALAMAT EMAIL</label>
									<div class="input-group  uk-text-center">
										<i class="uk-icon-envelope-o"></i>
										<input type="email" id="email-forgot" placeholder="Masukkan Email">
									</div>
								</div>
								<div>
									<button type="submit" class="send-email">KIRIM EMAIL</button>
								</div>
							</form>
						</div>
						<div class="footer uk-text-center">
							<p>ATAU</p>
							<a href="">Lupa kata sandi?</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	<script>
		var sidebar = '';
	</script>
    <script src="{{ URL('/assets/js/backend/registrasi.js') }}"></script>
@stop