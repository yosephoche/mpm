$(document).ready(function(){

	if(sidebar == 'pertanyaan'){
		$('.m-sidebar').find('.uk-active').removeClass('uk-active');
		$('#sidebar-dm').addClass('uk-active');
		$('#sidebar-dm-pertanyaan').addClass('uk-active');
	}else if(sidebar == 'jawaban'){
		$('.m-sidebar').find('.uk-active').removeClass('uk-active');
		$('#sidebar-dm').addClass('uk-active');
		$('#sidebar-dm-jawaban').addClass('uk-active');
	}

	$('#kdjawaban').keypress(function (e) {
		if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	$('#form_pertanyaan').submit(function(e){
		e.preventDefault();
		$('#alert').addClass('uk-hidden');
		$('#alert').find('p').html('');
		var formData = new FormData();
		if($('#pertanyaan').val() === ''){
			$('#pertanyaan').addClass('error');
			$('#pertanyaan_err').addClass('error');
			$('#pertanyaan_err').html('Pertanyaan wajib di isi');
		}else{

			formData.append('pertanyaan', $('#pertanyaan').val());
			formData.append('_token', $('#_token').val());

			$.ajax({
				url: '/master/pertanyaan',
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
							location.href = '/master/pertanyaan';
						}, 2000);
					}else{
						$('#alert').removeClass('uk-alert-success');
						$('#alert').removeClass('uk-hidden');
						$('#alert').addClass('uk-alert-danger');
						$('#alert').find('p').html(msg.message);
					}
				}
			});
		}
	});

	$('#form_jawaban').submit(function(e){
		e.preventDefault();
		$('#alert').addClass('uk-hidden');
		$('#alert').find('p').html('');
		var formData = new FormData();
		if($('#pertanyaan').val() === ''){
			$('#pertanyaan').addClass('error');
			$('#pertanyaan_err').addClass('error');
			$('#pertanyaan_err').html('Pertanyaan wajib di isi');
		}else if($('#kdjawaban').val() === ''){
			$('#kdjawaban').addClass('error');
			$('#kdjawaban_err').addClass('error');
			$('#kdjawaban_err').html('Kode jawaban wajib di isi');
		}else if($('#jawaban').val() === ''){
			$('#jawaban').addClass('error');
			$('#jawaban_err').addClass('error');
			$('#jawaban_err').html('Jawaban wajib di isi');
		}else{

			formData.append('pertanyaan', $('#pertanyaan').val());
			formData.append('kdjawaban', $('#kdjawaban').val());
			formData.append('jawaban', $('#jawaban').val());
			formData.append('_token', $('#_token').val());

			$.ajax({
				url: '/master/jawaban',
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
							location.href = '/master/jawaban';
						}, 2000);
					}else{
						$('#alert').removeClass('uk-alert-success');
						$('#alert').removeClass('uk-hidden');
						$('#alert').addClass('uk-alert-danger');
						$('#alert').find('p').html(msg.message);
					}
				}
			});
		}
	});
});
