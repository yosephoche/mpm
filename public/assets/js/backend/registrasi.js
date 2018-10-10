$(document).ready(function(){

    if(sidebar == 'registrasi-user'){
        $('.m-sidebar').find('.uk-active').removeClass('uk-active');
        $('#sidebar-user').addClass('uk-active');
    }

    $('#registrasi-user').submit(function(e){
        var formData = new FormData(),
            pattern_email = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		e.preventDefault();
        $('#submit-save').attr('disabled', 'true');
        $('#submit-save').css('cursor', 'not-allowed');
		$('#alert').addClass('uk-hidden');
		$('#alert').find('p').html('');
		var formData = new FormData();
		if($('#nama_lengkap').val() === '' || $('#email').val() === '' || $('#kontak').val() === '' || !pattern_email.test($('#email').val()) || $('#password').val() === '' || $('#status_admin').val() === ''){
            if($('#nama_lengkap').val() === ''){
            	$('#nama_lengkap').addClass('error');
    			$('#nama_lengkap_err').html('Nama lengkap wajib di isi');
            }else{
                $('#nama_lengkap').removeClass('error');
    			$('#nama_lengkap_err').html('');
            }
            if($('#email').val() === ''){
    			$('#email').addClass('error');
    			$('#email_err').html('Email wajib di isi');
            }else if(!pattern_email.test($('#email_register').val())){
                $('#email').addClass('error');
    			$('#email_err').html('Email tidak valid');
            }else{
                $('#email').removeClass('error');
    			$('#email_err').html('');
            }

            if($('#password').val() === ''){
	            $('#password').addClass('error');
    			$('#password_err').html('Kata sandi wajib di isi');
            }else{
                $('#password').removeClass('error');
                $('#password_err').html('');
            }

            if($('#kontak').val() === ''){
                $('#kontak').addClass('error');
                $('#kontak_err').html('Kata sandi wajib di isi');
            }else{
                $('#kontak').removeClass('error');
                $('#kontak_err').html('');
            }

            if($('#status_admin').val() === ''){
                $('#status_admin').parent('div').addClass('error');
                $('#status_admin_err').html('Status pengguna wajib di isi');
            }else{
                $('#status_admin').parent('div').removeClass('error');
                $('#status_admin_err').html('');
            }
            $('#submit-save').removeAttr('disabled');
            $('#submit-save').css('cursor', 'pointer');
        }else{

            formData.append('nama_lengkap', $('#nama_lengkap').val());
            formData.append('email', $('#email').val());
            formData.append('password', $('#password').val());
            formData.append('kontak', $('#kontak').val());
			formData.append('status', $('#status_admin').val());
			formData.append('_token', $('#_token').val());

			$.ajax({
				url: '/pengguna/registrasi',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data) {
					msg = $.parseJSON(data);
					if(msg.success == 1){
						$('#alert').removeClass('uk-alert-danger');
						$('#alert').removeClass('uk-hidden');
						$('#alert').addClass('uk-alert-success');
						$('#alert').find('p').html(msg.message);
						setTimeout(function(){
							location.href = '/pengguna/registrasi';
						}, 2000);
					}else{
						$('#alert').removeClass('uk-alert-success');
						$('#alert').removeClass('uk-hidden');
						$('#alert').addClass('uk-alert-danger');
						$('#alert').find('p').html(msg.message);
                        $('#submit-save').removeAttr('disabled');
                        $('#submit-save').css('cursor', 'pointer');
					}
				},
            	error: function(response){
                    $('#alert').removeClass('uk-alert-success');
                    $('#alert').removeClass('uk-hidden');
                    $('#alert').addClass('uk-alert-danger');
                    $('#alert').find('p').html('Terjadi kesalahan. Silahkan ulangi beberapa saat lagi');
                    $('#submit-save').removeAttr('disabled');
                    $('#submit-save').css('cursor', 'pointer');
                }
			});
		}
	});

    $(document).on('click', '#del-user', function(){
        $('#delUser').attr('data-id', $(this).attr('data-id'));
        $.UIkit.modal('#modal-del').show();
    });

    $('#delUser').on('click', function(){
        $.ajax({
            type: 'GET',
            url: '/pengguna/hapus/'+ $('#delUser').attr('data-id'),
            success: function(data){
                msg = $.parseJSON(data);
                if(msg.success == 1){
                    $('#alert-modal').removeClass('uk-alert-danger');
                    $('#alert-modal').removeClass('uk-hidden');
                    $('#alert-modal').addClass('uk-alert-success');
                    $('#alert-modal').find('p').html(msg.message);
                    setTimeout(function(){
                        location.reload(true);
                    }, 1000);
                }else{
                    $('#alert-modal').removeClass('uk-alert-success');
                    $('#alert-modal').removeClass('uk-hidden');
                    $('#alert-modal').addClass('uk-alert-danger');
                    $('#alert-modal').find('p').html(msg.message);
                }
            },
            error : function(response){
                $('#alert-modal').removeClass('uk-alert-success');
                $('#alert-modal').removeClass('uk-hidden');
                $('#alert-modal').addClass('uk-alert-danger');
                $('#alert-modal').find('p').html('Terjadi Kesalahan. Silahkan ulangi beberapa saat lagi.');
            }
        });
    });

    $('#update-user').submit(function(e){
        var formData = new FormData(),
            pattern_email = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
        e.preventDefault();
        $('#submit-update').attr('disabled', 'true');
        $('#submit-update').css('cursor', 'not-allowed');
        $('#alert').addClass('uk-hidden');
        $('#alert').find('p').html('');
        var formData = new FormData();
        if($('#nama_lengkap').val() === '' || $('#email').val() === '' || $('#kontak').val() === '' || !pattern_email.test($('#email').val()) || $('#status_admin').val() === ''){
            if($('#nama_lengkap').val() === ''){
                $('#nama_lengkap').addClass('error');
                $('#nama_lengkap_err').html('Nama lengkap wajib di isi');
            }else{
                $('#nama_lengkap').removeClass('error');
                $('#nama_lengkap_err').html('');
            }
            if($('#email').val() === ''){
                $('#email').addClass('error');
                $('#email_err').html('Email wajib di isi');
            }else if(!pattern_email.test($('#email_register').val())){
                $('#email').addClass('error');
                $('#email_err').html('Email tidak valid');
            }else{
                $('#email').removeClass('error');
                $('#email_err').html('');
            }

            if($('#kontak').val() === ''){
                $('#kontak').addClass('error');
                $('#kontak_err').html('Kata sandi wajib di isi');
            }else{
                $('#kontak').removeClass('error');
                $('#kontak_err').html('');
            }

            if($('#status_admin').val() === ''){
                $('#status_admin').parent('div').addClass('error');
                $('#status_admin_err').html('Status pengguna wajib di isi');
            }else{
                $('#status_admin').parent('div').removeClass('error');
                $('#status_admin_err').html('');
            }
            $('#submit-update').removeAttr('disabled');
            $('#submit-update').css('cursor', 'pointer');
        }else{

            formData.append('iduser', $('#submit-update').attr('data-id'));
            formData.append('nama_lengkap', $('#nama_lengkap').val());
            formData.append('email', $('#email').val());
            formData.append('kontak', $('#kontak').val());
            formData.append('status', $('#status_admin').val());
            formData.append('_token', $('#_token').val());

            $.ajax({
                url: '/pengguna/update',
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    msg = $.parseJSON(data);
                    if(msg.success == 1){
                        $('#alert').removeClass('uk-alert-danger');
                        $('#alert').removeClass('uk-hidden');
                        $('#alert').addClass('uk-alert-success');
                        $('#alert').find('p').html(msg.message);
                        setTimeout(function(){
                            location.reload(true);
                        }, 2000);
                    }else{
                        $('#alert').removeClass('uk-alert-success');
                        $('#alert').removeClass('uk-hidden');
                        $('#alert').addClass('uk-alert-danger');
                        $('#alert').find('p').html(msg.message);
                        $('#submit-update').removeAttr('disabled');
                        $('#submit-update').css('cursor', 'pointer');
                    }
                },
                error : function(response){
                    $('#alert').removeClass('uk-alert-success');
                    $('#alert').removeClass('uk-hidden');
                    $('#alert').addClass('uk-alert-danger');
                    $('#alert').find('p').html('Terjadi kesalahan. Silahkan ulangi beberapa saat lagi.');
                    $('#submit-update').removeAttr('disabled');
                    $('#submit-update').css('cursor', 'pointer');
                }
            });
        }
    });

    $('#modal-pass').on('click', function(){
        $('#password').val('');
        $('#repeat-password').val('');

    });

    $('#update-password').submit(function(e){
        var formData = new FormData();
        e.preventDefault();
        $('#submit-update-pass').attr('disabled', 'true');
        $('#submit-update-pass').css('cursor', 'not-allowed');
        $('#alert').addClass('uk-hidden');
        $('#alert').find('p').html('');
        var formData = new FormData();
        if($('#password').val() === ''){
            $('#password').addClass('error');
            $('#password_err').html('Kata sandi wajib di isi');
            $('#submit-update-pass').removeAttr('disabled');
            $('#submit-update-pass').css('cursor', 'pointer');
        }else if($('#repeat-password').val() === ''){
            $('#repeat-password').addClass('error');
            $('#repeat-password_err').html('Ulangi kata sandi wajib diisi');
            $('#submit-update-pass').removeAttr('disabled');
            $('#submit-update-pass').css('cursor', 'pointer');
        }else if($('#repeat-password').val() !== $('#password').val()){
            $('#repeat-password').addClass('error');
            $('#repeat-password_err').html('Kata sandi tidak sesuai');
            $('#submit-update-pass').removeAttr('disabled');
            $('#submit-update-pass').css('cursor', 'pointer');
        }else{

            formData.append('iduser', $('#submit-update-pass').attr('data-id'));
            formData.append('password', $('#repeat-password').val());
            formData.append('_token', $('#_token').val());

            $.ajax({
                url: '/pengguna/update/password',
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    msg = $.parseJSON(data);
                    if(msg.success == 1){
                        $('#alert-modal').removeClass('uk-alert-danger');
                        $('#alert-modal').removeClass('uk-hidden');
                        $('#alert-modal').addClass('uk-alert-success');
                        $('#alert-modal').find('p').html(msg.message);
                        setTimeout(function(){
                            location.reload(true);
                        }, 1000);
                    }else{
                        $('#alert-modal').removeClass('uk-alert-success');
                        $('#alert-modal').removeClass('uk-hidden');
                        $('#alert-modal').addClass('uk-alert-danger');
                        $('#alert-modal').find('p').html(msg.message);
                        $('#submit-update-pass').removeAttr('disabled');
                        $('#submit-update-pass').css('cursor', 'pointer');
                    }
                },
                error : function(response){
                    $('#alert-modal').removeClass('uk-alert-success');
                    $('#alert-modal').removeClass('uk-hidden');
                    $('#alert-modal').addClass('uk-alert-danger');
                    $('#alert-modal').find('p').html('Terjadi kesalahan. Silahkan ulangi beberapa saat lagi.');
                    $('#submit-update-pass').removeAttr('disabled');
                    $('#submit-update-pass').css('cursor', 'pointer');
                }
            });
        }
    });

    $('#pengaturan-user').submit(function(e){
        var formData = new FormData(),
            pattern_email = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
        e.preventDefault();
        $('#submit-update').attr('disabled', 'true');
        $('#submit-update').css('cursor', 'not-allowed');
        $('#alert').addClass('uk-hidden');
        $('#alert').find('p').html('');
        var formData = new FormData();
        if($('#nama_lengkap').val() === '' || $('#email').val() === '' || $('#kontak').val() === '' || !pattern_email.test($('#email').val())){
            if($('#nama_lengkap').val() === ''){
                $('#nama_lengkap').addClass('error');
                $('#nama_lengkap_err').html('Nama lengkap wajib di isi');
            }else{
                $('#nama_lengkap').removeClass('error');
                $('#nama_lengkap_err').html('');
            }
            if($('#email').val() === ''){
                $('#email').addClass('error');
                $('#email_err').html('Email wajib di isi');
            }else if(!pattern_email.test($('#email_register').val())){
                $('#email').addClass('error');
                $('#email_err').html('Email tidak valid');
            }else{
                $('#email').removeClass('error');
                $('#email_err').html('');
            }

            if($('#kontak').val() === ''){
                $('#kontak').addClass('error');
                $('#kontak_err').html('Kata sandi wajib di isi');
            }else{
                $('#kontak').removeClass('error');
                $('#kontak_err').html('');
            }

            $('#submit-update').removeAttr('disabled');
            $('#submit-update').css('cursor', 'pointer');
        }else{

            formData.append('iduser', $('#submit-update').attr('data-id'));
            formData.append('nama_lengkap', $('#nama_lengkap').val());
            formData.append('email', $('#email').val());
            formData.append('kontak', $('#kontak').val());
            formData.append('_token', $('#_token').val());

            $.ajax({
                url: '/pengaturan/pengguna',
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    msg = $.parseJSON(data);
                    if(msg.success == 1){
                        $('#alert').removeClass('uk-alert-danger');
                        $('#alert').removeClass('uk-hidden');
                        $('#alert').addClass('uk-alert-success');
                        $('#alert').find('p').html(msg.message);
                        setTimeout(function(){
                            location.reload(true);
                        }, 2000);
                    }else{
                        $('#alert').removeClass('uk-alert-success');
                        $('#alert').removeClass('uk-hidden');
                        $('#alert').addClass('uk-alert-danger');
                        $('#alert').find('p').html(msg.message);
                        $('#submit-update').removeAttr('disabled');
                        $('#submit-update').css('cursor', 'pointer');
                    }
                },
                error : function(response){
                    $('#alert').removeClass('uk-alert-success');
                    $('#alert').removeClass('uk-hidden');
                    $('#alert').addClass('uk-alert-danger');
                    $('#alert').find('p').html('Terjadi kesalahan. Silahkan ulangi beberapa saat lagi.');
                    $('#submit-update').removeAttr('disabled');
                    $('#submit-update').css('cursor', 'pointer');
                }
            });
        }
    });

    $('#form-send-email').submit(function(e){
        var formData = new FormData();
        e.preventDefault();
        if($('#email-forgot').val() == ''){
            $('#email-forgot').parent('div').addClass('error');
        }else{
            formData.append('email', $('#email-forgot').val());
            formData.append('_token', $('#_token').val());

            $.ajax({
                url: '/sendemailforgot',
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    msg = $.parseJSON(data);
                    if(msg.success == 1){
                        $('#alert').removeClass('uk-alert-danger');
                        $('#alert').removeClass('uk-hidden');
                        $('#alert').addClass('uk-alert-success');
                        $('#alert').find('p').html(msg.message);
                        
                    }else{
                        $('#alert').removeClass('uk-alert-success');
                        $('#alert').removeClass('uk-hidden');
                        $('#alert').addClass('uk-alert-danger');
                        $('#alert').find('p').html(msg.message);
                    }
                },
                error : function(response){
                    $('#alert').removeClass('uk-alert-success');
                    $('#alert').removeClass('uk-hidden');
                    $('#alert').addClass('uk-alert-danger');
                    $('#alert').find('p').html('Terjadi kesalahan. Silahkan ulangi beberapa saat lagi.');
                }
            });
        }
    });

    $('#form-reset-pass').submit(function(e){
        var formData = new FormData();
        e.preventDefault();
        if($('#password').val() == ''){
            $('#password').parent('div').addClass('error');
        }else{
            formData.append('id', $('.send-email').attr('data-id'));
            formData.append('password', $('#password').val());
            formData.append('_token', $('#_token').val());

            $.ajax({
                url: '/reset-password',
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    msg = $.parseJSON(data);
                    if(msg.success == 1){
                        $('#alert').removeClass('uk-alert-danger');
                        $('#alert').removeClass('uk-hidden');
                        $('#alert').addClass('uk-alert-success');
                        $('#alert').find('p').html(msg.message);
                        setTimeout(function(){
                            location.href = '/globallogin';
                        }, 2000);
                    }else{
                        $('#alert').removeClass('uk-alert-success');
                        $('#alert').removeClass('uk-hidden');
                        $('#alert').addClass('uk-alert-danger');
                        $('#alert').find('p').html(msg.message);
                    }
                },
                error : function(response){
                    $('#alert').removeClass('uk-alert-success');
                    $('#alert').removeClass('uk-hidden');
                    $('#alert').addClass('uk-alert-danger');
                    $('#alert').find('p').html('Terjadi kesalahan. Silahkan ulangi beberapa saat lagi.');
                }
            });
        }
    });
});
