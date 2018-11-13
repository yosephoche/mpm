@extends('UserManagement::layouts.main')

@section('content')
<div class="main-login">
		<div class="ml-wrapper">
			<div class="ml-inner">
				<div class="uk-clearfix">
					<div class="left uk-float-left uk-hidden-small">
						<div class="form-image"></div>
					</div>
					<div class="right uk-text-center">
						<div class="header" style="padding: 20px 15px;">
							<a href="/"><h3>Si Emas Terpadu</h3></a>
							<p>( Sistem Informasi Pengetasan Kemiskinan Terpadu )</p>
						</div>
						<div action="" class="ml-form">
							<h4>Silahkan masukkan kata sandi baru Anda.</h4>
							<form class="mlf-input" id="form-reset-pass" method="post" action="{{ URL('/globallogin') }}">
							<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
								<div id="alert" class="uk-alert uk-alert-small uk-hidden" data-uk-alert>
                                    <p></p>
                                </div>
								<div>
									<label for="username">KATA SANDI BARU</label>
									<div class="input-group  uk-text-center">
										<i class="uk-icon-key"></i>
										<input type="password" placeholder="Masukkan Kata Sandi" name="password" id="password">
									</div>
								</div>
								<div>
									<button type="submit" data-id="{{ $user[0]->_id }}" class="send-email">RESET SANDI</button>
								</div>
							</form>
							<form class="mlf-input" id="form-send-email">
								
							</form>
						</div>
						<div class="uk-text-center" style="border-top: 1px solid #d6d6d6;position: absolute;left: 270px;right: 0;bottom: 0;height: 75px;">
							<p style="position: relative;padding: 5px 10px;top: -14px;background: #fff;display: table;margin: 0 auto;">ATAU</p>
							<a href="{{ URL('/globallogin') }}" style="color: #f7b753;text-decoration: none;">Kembali ke halaman login</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	<style>

        .main-login:before {
            background: url('/assets/img/login_bg.png') no-repeat center top;
            background-size: cover;
        }
        .main-login .ml-wrapper .ml-inner .left .form-image {
		    background: rgba(0, 0, 0, 0) url("/assets/img/form_img.png") no-repeat scroll center center / cover ;
		}

    </style>
	<script>
		var sidebar = '';
	
	</script>
    <script src="{{ URL('/assets/js/backend/registrasi.js') }}"></script>
@stop