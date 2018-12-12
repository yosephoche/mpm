$(document).ready(function(){

	Array.prototype.unique =
	  function() {
	    var a = [];
	    var l = this.length;
	    for(var i=0; i<l; i++) {
	      for(var j=i+1; j<l; j++) {
	        // If this[i] is found later in the array
	        if (this[i] === this[j])
	          j = ++i;
	      }
	      a.push(this[i]);
	    }
	    return a;
	  };

	if(sidebar == 'indi-var'){
		$('.m-sidebar').find('.uk-active').removeClass('uk-active');
		$('#sidebar-dm').addClass('uk-active');
		$('#sidebar-dm-indikator-variabel').addClass('uk-active');
	} else if(sidebar == 'indi-opsi'){
		$('.m-sidebar').find('.uk-active').removeClass('uk-active');
		$('#sidebar-dm').addClass('uk-active');
		$('#sidebar-dm-indikator-opsi').addClass('uk-active');
	} else if(sidebar == 'indi-opd') {
		$('.m-sidebar').find('.uk-active').removeClass('uk-active');
		$('#sidebar-dm').addClass('uk-active');
		$('#sidebar-dm-opd').addClass('uk-active');
	} else if (sidebar == 'indi-jenis') {
		$('.m-sidebar').find('.uk-active').removeClass('uk-active');
		$('#sidebar-dm').addClass('uk-active');
		$('#sidebar-dm-jenis-kegiatan').addClass('uk-active');
	} else if (sidebar == 'indi-indikator-kegiatan') {
		$('.m-sidebar').find('.uk-active').removeClass('uk-active');
		$('#sidebar-dm').addClass('uk-active');
		$('#sidebar-dm-indikator-kegiatan').addClass('uk-active');
	} else if (sidebar == 'indi-tahun-anggaran') {
		$('.m-sidebar').find('.uk-active').removeClass('uk-active');
		$('#sidebar-dm').addClass('uk-active');
		$('#sidebar-dm-tahun-anggaran').addClass('uk-active');
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

	$('#form_master_opd').submit(function(e){
		var formData = new FormData();
		e.preventDefault();
		$('#submit-save').attr('disabled', 'true');
		$('#submit-save').css('cursor', 'not-allowed');
		$('#alert-indi-var').addClass('uk-hidden');
		$('#alert-indi-var').find('p').html('');
		var formData = new FormData();
		if($('#name_opd').val() === ''){
			if($('#name_opd').val() === ''){
				$('#name_opd').parent('div').addClass('error');
				$('#name_opd_err').html('Nama OPD wajib di isi');
			}else{
				$('#name_opd').parent('div').removeClass('error');
				$('#name_opd_err').html('');
			}

			$('#submit-save').removeAttr('disabled');
			$('#submit-save').css('cursor', 'pointer');
		}else{
			formData.append('name_opd', $('#name_opd').val());
			formData.append('_token', $('#_token').val());

			$.ajax({
				url: '/master/opd/input',
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

	$(document).on('click', '#del-opd', function(){
		$('#delOpd').attr('data-id', $(this).attr('data-id'));
		$.UIkit.modal('#modal-del').show();
	});

	$('#delOpd').on('click', function(){
		$.ajax({
			type: 'GET',
			url: '/master/opd/delete/'+ $(this).attr('data-id'),
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

	$('#form_master_opd_update').submit(function(e){
		var formData = new FormData();
		e.preventDefault();
		$('#submit-save').attr('disabled', 'true');
		$('#submit-save').css('cursor', 'not-allowed');
		$('#alert-indi-var').addClass('uk-hidden');
		$('#alert-indi-var').find('p').html('');
		var formData = new FormData();
		if($('#name_opd').val() === ''){
			if($('#name_opd').val() === ''){
				$('#name_opd').parent('div').addClass('error');
				$('#name_opd_err').html('Nama OPD wajib di isi');
			}else{
				$('#name_opd').parent('div').removeClass('error');
				$('#name_opd_err').html('');
			}

			$('#submit-save').removeAttr('disabled');
			$('#submit-save').css('cursor', 'pointer');
		}else{
			formData.append('name_opd', $('#name_opd').val());
			formData.append('_token', $('#_token').val());
			formData.append('idOpd', $('#submit-save').attr('data-id'));

			$.ajax({
				url: '/master/opd/update',
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
					console.log(response);
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

	$('#form_master_jenis_kegiatan').submit(function(e){
		var formData = new FormData();
		e.preventDefault();
		$('#submit-save').attr('disabled', 'true');
		$('#submit-save').css('cursor', 'not-allowed');
		$('#alert-indi-var').addClass('uk-hidden');
		$('#alert-indi-var').find('p').html('');
		var formData = new FormData();
		if($('#name_jenis_kegiatan').val() === ''){
			if($('#name_jenis_kegiatan').val() === ''){
				$('#name_jenis_kegiatan').parent('div').addClass('error');
				$('#name_jenis_kegiatan_err').html('Nama Jenis Kegiatan wajib di isi');
			}else{
				$('#name_jenis_kegiatan').parent('div').removeClass('error');
				$('#name_jenis_kegiatan_err').html('');
			}

			$('#submit-save').removeAttr('disabled');
			$('#submit-save').css('cursor', 'pointer');
		}else{
			formData.append('name_jenis_kegiatan', $('#name_jenis_kegiatan').val());
			formData.append('_token', $('#_token').val());

			$.ajax({
				url: '/master/jenis-kegiatan/input',
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

	$('#form_master_jenis_kegiatan_update').submit(function(e){
		var formData = new FormData();
		e.preventDefault();
		$('#submit-save').attr('disabled', 'true');
		$('#submit-save').css('cursor', 'not-allowed');
		$('#alert-indi-var').addClass('uk-hidden');
		$('#alert-indi-var').find('p').html('');
		var formData = new FormData();
		if($('#name_jenis_kegiatan').val() === ''){
			if($('#name_jenis_kegiatan').val() === ''){
				$('#name_jenis_kegiatan').parent('div').addClass('error');
				$('#name_jenis_kegiatan_err').html('Nama OPD wajib di isi');
			}else{
				$('#name_jenis_kegiatan').parent('div').removeClass('error');
				$('#name_jenis_kegiatan_err').html('');
			}

			$('#submit-save').removeAttr('disabled');
			$('#submit-save').css('cursor', 'pointer');
		}else{
			formData.append('name_jenis_kegiatan', $('#name_jenis_kegiatan').val());
			formData.append('_token', $('#_token').val());
			formData.append('idJenis', $('#submit-save').attr('data-id'));

			$.ajax({
				url: '/master/jenis-kegiatan/update',
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
					console.log(response);
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

	$(document).on('click', '#del-jenis-kegiatan', function(){
		$('#delJenisKegiatan').attr('data-id', $(this).attr('data-id'));
		$.UIkit.modal('#modal-del').show();
	});

	$('#delJenisKegiatan').on('click', function(){
		$.ajax({
			type: 'GET',
			url: '/master/jenis-kegiatan/delete/'+ $(this).attr('data-id'),
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

	//master indikator kegiatan
	$('#form_master_indikator_kegiatan').submit(function (e) {
		console.log(3);
		var formData = new FormData();
		e.preventDefault();
		var rt_var = {},
			arr_rt = [],
			status_rt = 1;

		var values = $('input[data-status^=rt]').map(function() {
			arr_rt.push(this.name);
		}).get();

		$.each(arr_rt.unique(), function(i, el){
			if($('input[name='+el+']:checked').val() === undefined){
				status_rt = 0;
			}else{
				rt_var[el] = $('input[name='+el+']:checked').val();
			}
		});

		$('#submit-save').attr('disabled', 'true');
		$('#submit-save').css('cursor', 'not-allowed');
		$('#alert-indi-var').addClass('uk-hidden');
		$('#alert-indi-var').find('p').html('');

		console.log(values);
		console.log(rt_var);

		if($('#name_indikator_kegiatan').val() === ''){
			if($('#name_indikator_kegiatan').val() === ''){
				$('#name_indikator_kegiatan').parent('div').addClass('error');
				$('#name_indikator_kegiatan_err').html('Nama Indikator Kegiatan wajib di isi');
			}else{
				$('#name_indikator_kegiatan').parent('div').removeClass('error');
				$('#name_indikator_kegiatan_err').html('');
			}

			$('#submit-save').removeAttr('disabled');
			$('#submit-save').css('cursor', 'pointer');
		}else{
			formData.append('name_indikator_kegiatan',$('#name_indikator_kegiatan').val());
			formData.append('rtVar', JSON.stringify(rt_var));
			formData.append('_token', $('#_token').val());

			$.ajax({
				url: '/master/indikator-kegiatan/input',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data) {
					msg = $.parseJSON(data);
					if(msg.success == 1){
						$('#alert').removeClass('uk-alert-warning');
						$('#alert').removeClass('uk-hidden');
						$('#alert').addClass('uk-alert-success');
						$('#alert').find('p').html(msg.message);
						setTimeout(function(){
							location.reload(true);
						}, 2000);
					}else{
						$('#alert').removeClass('uk-alert-success');
						$('#alert').removeClass('uk-hidden');
						$('#alert').addClass('uk-alert-warning');
						$('#alert').find('p').html(msg.message);
						$('#submit-save').removeAttr('disabled');
						$('#submit-save').css('cursor', 'pointer');
					}
				},
				error: function(response){
					$('#alert').removeClass('uk-alert-success');
					$('#alert').removeClass('uk-hidden');
					$('#alert').addClass('uk-alert-warning');
					$('#alert').find('p').html('Terjadi kesalahan. Silahkan ulangi beberapa saat lagi');
					$('#submit-save').removeAttr('disabled');
					$('#submit-save').css('cursor', 'pointer');
				}
			});
		}
	});

	$('#form_master_indikator_kegiatan_update').submit(function (e) {
		console.log(3);
		var formData = new FormData();
		e.preventDefault();
		var rt_var = {},
			arr_rt = [],
			status_rt = 1;

		var values = $('input[data-status^=rt]').map(function() {
			arr_rt.push(this.name);
		}).get();

		$.each(arr_rt.unique(), function(i, el){
			if($('input[name='+el+']:checked').val() === undefined){
				status_rt = 0;
			}else{
				rt_var[el] = $('input[name='+el+']:checked').val();
			}
		});

		$('#submit-save').attr('disabled', 'true');
		$('#submit-save').css('cursor', 'not-allowed');
		$('#alert-indi-var').addClass('uk-hidden');
		$('#alert-indi-var').find('p').html('');

		console.log(values);
		console.log(rt_var);

		if($('#name_indikator_kegiatan').val() === ''){
			if($('#name_indikator_kegiatan').val() === ''){
				$('#name_indikator_kegiatan').parent('div').addClass('error');
				$('#name_indikator_kegiatan_err').html('Nama Indikator Kegiatan wajib di isi');
			}else{
				$('#name_indikator_kegiatan').parent('div').removeClass('error');
				$('#name_indikator_kegiatan_err').html('');
			}

			$('#submit-save').removeAttr('disabled');
			$('#submit-save').css('cursor', 'pointer');
		}else{
			formData.append('name_indikator_kegiatan',$('#name_indikator_kegiatan').val());
			formData.append('rtVar', JSON.stringify(rt_var));
			formData.append('_token', $('#_token').val());
			formData.append('idIndikator', $('#submit-save').attr('data-id'));

			$.ajax({
				url: '/master/indikator-kegiatan/update',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data) {
					msg = $.parseJSON(data);
					if(msg.success == 1){
						$('#alert').removeClass('uk-alert-warning');
						$('#alert').removeClass('uk-hidden');
						$('#alert').addClass('uk-alert-success');
						$('#alert').find('p').html(msg.message);
						setTimeout(function(){
							location.reload(true);
						}, 2000);
					}else{
						$('#alert').removeClass('uk-alert-success');
						$('#alert').removeClass('uk-hidden');
						$('#alert').addClass('uk-alert-warning');
						$('#alert').find('p').html(msg.message);
						$('#submit-save').removeAttr('disabled');
						$('#submit-save').css('cursor', 'pointer');
					}
				},
				error: function(response){
					$('#alert').removeClass('uk-alert-success');
					$('#alert').removeClass('uk-hidden');
					$('#alert').addClass('uk-alert-warning');
					$('#alert').find('p').html('Terjadi kesalahan. Silahkan ulangi beberapa saat lagi');
					$('#submit-save').removeAttr('disabled');
					$('#submit-save').css('cursor', 'pointer');
				}
			});
		}
	});

	$(document).on('click', '#del-indikator-kegiatan', function(){
		$('#delIndikatorKegiatan').attr('data-id', $(this).attr('data-id'));
		$.UIkit.modal('#modal-del').show();
	});

	$('#delIndikatorKegiatan').on('click', function(){
		$.ajax({
			type: 'GET',
			url: '/master/indikator-kegiatan/delete/'+ $(this).attr('data-id'),
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

	//master tahun anggaran
	$('#tahun_anggaran').keypress(function (e) {
		if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	$('#form_master_tahun_anggaran').submit(function(e){
		var formData = new FormData();
		e.preventDefault();
		$('#submit-save').attr('disabled', 'true');
		$('#submit-save').css('cursor', 'not-allowed');
		$('#alert-indi-var').addClass('uk-hidden');
		$('#alert-indi-var').find('p').html('');
		var formData = new FormData();
		if($('#tahun_anggaran').val() === ''){
			if($('#tahun_anggaran').val() === ''){
				$('#tahun_anggaran').parent('div').addClass('error');
				$('#tahun_anggaran_err').html('Tahun Anggaran wajib di isi');
			}else{
				$('#tahun_anggaran').parent('div').removeClass('error');
				$('#tahun_anggaran_err').html('');
			}

			$('#submit-save').removeAttr('disabled');
			$('#submit-save').css('cursor', 'pointer');
		}else{
			formData.append('tahun_anggaran', $('#tahun_anggaran').val());
			formData.append('_token', $('#_token').val());

			$.ajax({
				url: '/master/tahun-anggaran/input',
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

	$(document).on('click', '#del-tahun-anggaran', function(){
		$('#delTahunAnggaran').attr('data-id', $(this).attr('data-id'));
		$.UIkit.modal('#modal-del').show();
	});

	$('#delTahunAnggaran').on('click', function(){
		$.ajax({
			type: 'GET',
			url: '/master/tahun-anggaran/delete/'+ $(this).attr('data-id'),
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

	$('#form_master_tahun_anggaran_update').submit(function(e){
		var formData = new FormData();
		e.preventDefault();
		$('#submit-save').attr('disabled', 'true');
		$('#submit-save').css('cursor', 'not-allowed');
		$('#alert-indi-var').addClass('uk-hidden');
		$('#alert-indi-var').find('p').html('');
		var formData = new FormData();
		if($('#tahun_anggaran').val() === ''){
			if($('#tahun_anggaran').val() === ''){
				$('#tahun_anggaran').parent('div').addClass('error');
				$('#tahun_anggaran_err').html('Nama OPD wajib di isi');
			}else{
				$('#tahun_anggaran').parent('div').removeClass('error');
				$('#tahun_anggaran_err').html('');
			}

			$('#submit-save').removeAttr('disabled');
			$('#submit-save').css('cursor', 'pointer');
		}else{
			formData.append('tahun_anggaran', $('#tahun_anggaran').val());
			formData.append('_token', $('#_token').val());
			formData.append('idTahunAnggaran', $('#submit-save').attr('data-id'));

			$.ajax({
				url: '/master/tahun-anggaran/update',
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
					console.log(response);
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
});
