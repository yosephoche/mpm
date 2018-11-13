$(document).ready(function(){

	if(sidebar == 'indi-var'){
		$('.m-sidebar').find('.uk-active').removeClass('uk-active');
		$('#sidebar-dm').addClass('uk-active');
		$('#sidebar-dm-indikator-variabel').addClass('uk-active');
	}else if(sidebar == 'indi-opsi'){
		$('.m-sidebar').find('.uk-active').removeClass('uk-active');
		$('#sidebar-dm').addClass('uk-active');
		$('#sidebar-dm-indikator-opsi').addClass('uk-active');
	}


	$('#no-opsi').keypress(function (e) {
		if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	$('#form_indikator_var').submit(function(e){
		var formData = new FormData();
		e.preventDefault();
		$('#submit-save').attr('disabled', 'true');
		$('#submit-save').css('cursor', 'not-allowed');
		$('#alert-indi-var').addClass('uk-hidden');
		$('#alert-indi-var').find('p').html('');
		var formData = new FormData();
		if($('#tingkat-variabel').val() === '' || $('#kode-variabel').val() === '' || $('#nama-variabel').val() === '' || $('#cara-isi').val() === '' || $('#jenisindikator').val() === '' ){
			if($('#tingkat-variabel').val() === ''){
				$('#tingkat-variabel').parent('div').addClass('error');
				$('#tingkat-variabel_err').html('Tingkat variabel wajib di isi');
			}else{
				$('#tingkat-variabel').parent('div').removeClass('error');
				$('#tingkat-variabel_err').html('');
			}

			if($('#kode-variabel').val() === ''){
				$('#kode-variabel').addClass('error');
				$('#kode-variabel_err').html('Kode Variabel wajib di isi');
			}else{
				$('#kode-variabel').removeClass('error');
				$('#kode-variabel_err').html('');
			}

			if($('#nama-variabel').val() === ''){
				$('#nama-variabel').addClass('error');
				$('#nama-variabel_err').html('Nama Variabel wajib di isi');
			}else{
				$('#nama-variabel').removeClass('error');
				$('#nama-variabel_err').html('');
			}

			if($('#cara-isi').val() === ''){
				$('#cara-isi').parent('div').addClass('error');
				$('#cara-isi_err').html('Cara isi wajib di isi');
			}else{
				$('#cara-isi').parent('div').removeClass('error');
				$('#cara-isi_err').html('');
			}

			if($('#jenisindikator').val() === ''){
				$('#jenisindikator').parent('div').addClass('error');
				$('#jenisindikator_err').html('Jenis indikator wajib di isi');
			}else{
				$('#jenisindikator').parent('div').removeClass('error');
				$('#jenisindikator_err').html('');
			}

			if($('#skpd').val() === ''){
				$('#skpd').parent('div').addClass('error');
				$('#skpd_err').html('SKPD wajib di isi');
			}else{
				$('#skpd').parent('div').removeClass('error');
				$('#skpd_err').html('');
			}
			$('#submit-save').removeAttr('disabled');
			$('#submit-save').css('cursor', 'pointer');
		}else{

			formData.append('tingkat_variabel', $('#tingkat-variabel').val());
			formData.append('nama_variabel', $('#nama-variabel').val());
			formData.append('jenis_indikator', $('#jenisindikator').val());
			formData.append('cara_isi', $('#cara-isi').val());
			formData.append('ket_satuan', $('#ket-satuan').val());
			formData.append('kode_variabel', $('#kode-variabel').val());
			formData.append('pendaftaran', $('#pendaftaran').val());
			formData.append('verifikasi', $('#verifikasi').val());
			formData.append('_token', $('#_token').val());

			$.ajax({
				url: '/master/indikator/variabel/input',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data) {
					msg = $.parseJSON(data);
					if(msg.success == 1){
						$('#alert-indi-var').removeClass('uk-alert-danger');
						$('#alert-indi-var').removeClass('uk-hidden');
						$('#alert-indi-var').addClass('uk-alert-success');
						$('#alert-indi-var').find('p').html(msg.message);
						setTimeout(function(){
							location.reload(true);
						}, 2000);
					}else{
						$('#alert-indi-var').removeClass('uk-alert-success');
						$('#alert-indi-var').removeClass('uk-hidden');
						$('#alert-indi-var').addClass('uk-alert-danger');
						$('#alert-indi-var').find('p').html(msg.message);
						$('#submit-save').removeAttr('disabled');
						$('#submit-save').css('cursor', 'pointer');
					}
				},
				error: function(response){
					$('#alert-indi-var').removeClass('uk-alert-success');
					$('#alert-indi-var').removeClass('uk-hidden');
					$('#alert-indi-var').addClass('uk-alert-danger');
					$('#alert-indi-var').find('p').html('Terjadi kesalahan. Silahkan ulangi beberapa saat lagi');
					$('#submit-save').removeAttr('disabled');
					$('#submit-save').css('cursor', 'pointer');
				}
			});
		}
	});

	$(document).on('click', '#del-indi-var', function(){
		$('#delIndiVar').attr('data-id', $(this).attr('data-id'));
		$.UIkit.modal('#modal-del').show();
	});

	$('#delIndiVar').on('click', function(){
		$.ajax({
			type: 'GET',
			url: '/master/indikator/variabel/delete/'+ $(this).attr('data-id'),
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

	/*$('#sub-opsi').on('change', function(){
		if($(this).val() === '1'){
			$('#opsi-indi').parent('div').parent('div').parent('div').removeClass('uk-hidden');
			$('#kode-sub').parent('div').parent('div').removeClass('uk-hidden');
			$('#nama-sub').parent('div').parent('div').removeClass('uk-hidden');
		}else{
			$('#opsi-indi').parent('div').parent('div').parent('div').addClass('uk-hidden');
			$('#kode-sub').parent('div').parent('div').addClass('uk-hidden');
			$('#nama-sub').parent('div').parent('div').addClass('uk-hidden');
		}
	});*/

	$('#nama-variabel').on('change', function(){
		if($('#sub-opsi').val() === '1'){
			$('#opsi-indi').empty();
			$('#opsi-indi').append('<option value="">Pilih Opsi Indikator</option>');
			$.ajax({
				type: 'GET',
				url: '/getopsiindi/'+ $(this).val(),
				success: function(data){
					msg = $.parseJSON(data);
					$.each(msg, function( key, value ) {
						$('#opsi-indi').append('<option value="'+value.no_opsi+'">'+value.no_opsi+'. '+value.desc_opsi+'</option>');
					});
				}
			});
		}
	});

	$('#form_indi_var_update').submit(function(e){
		var formData = new FormData();
		e.preventDefault();
		$('#submit-save').attr('disabled', 'true');
		$('#submit-save').css('cursor', 'not-allowed');
		$('#alert').addClass('uk-hidden');
		$('#alert').find('p').html('');
		var formData = new FormData();
		if($('#tingkat-variabel').val() === '' || $('#nama-variabel').val() === '' || $('#cara-isi').val() === '' || $('#kode-variabel').val() === '' || $('#jenisindikator').val() === ''){
			if($('#tingkat-variabel').val() === ''){
				$('#tingkat-variabel').parent('div').addClass('error');
				$('#tingkat-variabel_err').html('Tingkat variabel wajib di isi');
			}else{
				$('#tingkat-variabel').parent('div').removeClass('error');
				$('#tingkat-variabel_err').html('');
			}

			if($('#kode-variabel').val() === ''){
				$('#kode-variabel').addClass('error');
				$('#kode-variabel_err').html('Kode Variabel wajib di isi');
			}else{
				$('#kode-variabel').removeClass('error');
				$('#kode-variabel_err').html('');
			}

			if($('#nama-variabel').val() === ''){
				$('#nama-variabel').addClass('error');
				$('#nama-variabel_err').html('Nama Variabel wajib di isi');
			}else{
				$('#nama-variabel').removeClass('error');
				$('#nama-variabel_err').html('');
			}

			if($('#cara-isi').val() === ''){
				$('#cara-isi').parent('div').addClass('error');
				$('#cara-isi_err').html('Cara isi wajib di isi');
			}else{
				$('#cara-isi').parent('div').removeClass('error');
				$('#cara-isi_err').html('');
			}

			if($('#jenisindikator').val() === ''){
				$('#jenisindikator').parent('div').addClass('error');
				$('#jenisindikator_err').html('Jenis Indikator wajib di isi');
			}else{
				$('#jenisindikator').parent('div').removeClass('error');
				$('#jenisindikator_err').html('');
			}

			$('#submit-save').removeAttr('disabled');
			$('#submit-save').css('cursor', 'pointer');
		}else{

			formData.append('tingkat_variabel', $('#tingkat-variabel').val());
			formData.append('nama_variabel', $('#nama-variabel').val());
			formData.append('cara_isi', $('#cara-isi').val());
			formData.append('ket_satuan', $('#ket-satuan').val());
			formData.append('kode_variabel', $('#kode-variabel').val());
			formData.append('pendaftaran', $("#pendaftaran").val());
			formData.append('verifikasi', $("#verifikasi").val());
			formData.append('jenis_indikator', $("#jenisindikator").val());
			formData.append('idvar', $('#submit-save').attr('data-id'));
			formData.append('_token', $('#_token').val());

			$.ajax({
				url: '/master/indikator/variabel/update',
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

	$('#form_indikator_opsi').submit(function(e){
		var formData = new FormData();
		e.preventDefault();
		$('#submit-save').attr('disabled', 'true');
		$('#submit-save').css('cursor', 'not-allowed');
		$('#alert').addClass('uk-hidden');
		$('#alert').find('p').html('');
		var formData = new FormData();
		if($('#nama-variabel').val() === '' || $('#no-opsi').val() === '' || $('#desc-opsi').val() === ''){

			if($('#nama-variabel').val() === ''){
				$('#nama-variabel').parent('div').addClass('error');
				$('#nama-variabel_err').html('Nama Variabel wajib di isi');
			}else{
				$('#nama-variabel').parent('div').removeClass('error');
				$('#nama-variabel_err').html('');
			}

			/*if($('#nama-sub').val() === ''){
				$('#nama-sub').parent('div').addClass('error');
				$('#nama-sub_err').html('Nama Variabel wajib di isi');
			}else{
				$('#nama-sub').parent('div').removeClass('error');
				$('#nama-sub_err').html('');
			}*/

			/*if($('#sub-opsi').val() === ''){
				$('#sub-opsi').parent('div').addClass('error');
				$('#sub-opsi_err').html('Sub Opsi indikator wajib di isi');
			}else{
				$('#sub-opsi').parent('div').removeClass('error');
				$('#sub-opsi_err').html('');
			}*/

			if($('#no-opsi').val() === ''){
				$('#no-opsi').parent('div').addClass('error');
				$('#no-opsi_err').html('No. Opsi indikator wajib di isi');
			}else{
				$('#no-opsi').parent('div').removeClass('error');
				$('#no-opsi_err').html('');
			}

			/*if($('#opsi-indi').val() === ''){
				$('#opsi-indi').parent('div').addClass('error');
				$('#opsi-indi_err').html('Opsi indikator wajib di isi');
			}else{
				$('#opsi-indi').parent('div').removeClass('error');
				$('#opsi-indi_err').html('');
			}*/

			if($('#desc-opsi').val() === ''){
				$('#desc-opsi').parent('div').addClass('error');
				$('#desc-opsi_err').html('Opsi Indikator wajib di isi');
			}else{
				$('#desc-opsi').parent('div').removeClass('error');
				$('#desc-opsi_err').html('');
			}
			$('#submit-save').removeAttr('disabled');
			$('#submit-save').css('cursor', 'pointer');
		}else{

			/*formData.append('sub_opsi', $('#sub-opsi').val());*/
			formData.append('kode', $('#nama-variabel').val());
			/*formData.append('kode_sub', $('#kode-sub').val());
			formData.append('nama_sub', $('#nama-sub').val());*/
			/*formData.append('opsi_indi', $('#opsi-indi').val());*/
			formData.append('no_opsi', $('#no-opsi').val());
			formData.append('desc_opsi', $('#desc-opsi').val());
			/*formData.append('rincian', $('#rincian').val());*/
			formData.append('_token', $('#_token').val());

			$.ajax({
				url: '/master/indikator/opsi/input',
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
						}, 1000);
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

	$(document).on('click', '#del-indi-opsi', function(){
		$('#delIndiOpsi').attr('data-id', $(this).attr('data-id'));
		$.UIkit.modal('#modal-del').show();
	});

	$('#delIndiOpsi').on('click', function(){
		$.ajax({
			type: 'GET',
			url: '/master/indikator/opsi/delete/'+ $(this).attr('data-id'),
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

	$('#form_indikator_opsi_update').submit(function(e){
		var formData = new FormData();
		e.preventDefault();
		$('#submit-save').attr('disabled', 'true');
		$('#submit-save').css('cursor', 'not-allowed');
		$('#alert').addClass('uk-hidden');
		$('#alert').find('p').html('');
		var formData = new FormData();
		if($('#nama-variabel').val() === '' || $('#no-opsi').val() === '' || $('#desc-opsi').val() === ''){

			if($('#nama-variabel').val() === ''){
				$('#nama-variabel').parent('div').addClass('error');
				$('#nama-variabel_err').html('Nama Variabel wajib di isi');
			}else{
				$('#nama-variabel').parent('div').removeClass('error');
				$('#nama-variabel_err').html('');
			}

			if($('#no-opsi').val() === ''){
				$('#no-opsi').parent('div').addClass('error');
				$('#no-opsi_err').html('No. Opsi indikator wajib di isi');
			}else{
				$('#no-opsi').parent('div').removeClass('error');
				$('#no-opsi_err').html('');
			}

			if($('#desc-opsi').val() === ''){
				$('#desc-opsi').parent('div').addClass('error');
				$('#desc-opsi_err').html('Opsi Indikator wajib di isi');
			}else{
				$('#desc-opsi').parent('div').removeClass('error');
				$('#desc-opsi_err').html('');
			}
			$('#submit-save').removeAttr('disabled');
			$('#submit-save').css('cursor', 'pointer');
		}else{

			formData.append('kode', $('#nama-variabel').val());
			formData.append('no_opsi', $('#no-opsi').val());
			formData.append('desc_opsi', $('#desc-opsi').val());

			formData.append('id_opsi', $('#submit-save').attr('data-id'));
			formData.append('_token', $('#_token').val());

			$.ajax({
				url: '/master/indikator/opsi/update',
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
});
