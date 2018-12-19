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

	if(sidebar == 'pendaftaran-mpm'){
		$('.m-sidebar').find('.uk-active').removeClass('uk-active');
		$('#sidebar-fmpm').addClass('uk-active');
		$('#sidebar-fmpm-pendaftaran').addClass('uk-active');
	}else if(sidebar == 'list-mpm'){
		$('.m-sidebar').find('.uk-active').removeClass('uk-active');
		$('#sidebar-fmpm').addClass('uk-active');
		$('#sidebar-fmpm-list').addClass('uk-active');
	}

	$('#nik').keypress(function (e) {
		if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	$('#nomorKk').keypress(function (e) {
		if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	$('#anggaran_besaran').keypress(function (e) {
		if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	$('#anggaran_tahun_kegiatan').keypress(function (e) {
		if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	$('#form_anggaran_kegiatan_opd').submit(function (e) {
		e.preventDefault();
		var formData = new FormData();
		e.preventDefault();
		$('#submit-save').attr('disabled', 'true');
		$('#submit-save').css('cursor', 'not-allowed');
		$('#alert-indi-var').addClass('uk-hidden');
		$('#alert-indi-var').find('p').html('');
		var formData = new FormData();
		if($('#anggaran_nama_kegiatan').val() === ''){
			if($('#anggaran_nama_kegiatan').val() === ''){
				$('#anggaran_nama_kegiatan').parent('div').addClass('error');
				$('#anggaran_nama_kegiatan_err').html('Nama Jenis Kegiatan wajib di isi');
			}else{
				$('#anggaran_nama_kegiatan').parent('div').removeClass('error');
				$('#anggaran_nama_kegiatan_err').html('');
			}

			if($('#anggaran_besaran').val() === ''){
				$('#anggaran_besaran').parent('div').addClass('error');
				$('#anggaran_besaran_err').html('Besaran Anggaran wajib di isi');
			}else{
				$('#anggaran_besaran').parent('div').removeClass('error');
				$('#anggaran_besaran_err').html('');
			}

			if($('#anggaran_tahun_kegiatan').val() === ''){
				$('#anggaran_tahun_kegiatan').parent('div').addClass('error');
				$('#anggaran_tahun_kegiatan_err').html('Tahun Anggaran Kegiatan wajib di isi');
			}else{
				$('#anggaran_tahun_kegiatan').parent('div').removeClass('error');
				$('#anggaran_tahun_kegiatan_err').html('');
			}

			if($('#anggaran_jenis_kegiatan').val() === ''){
				$('#anggaran_jenis_kegiatan').parent('div').addClass('error');
				$('#anggaran_jenis_kegiatan_err').html('Jenis Kegiatan wajib di isi');
			}else{
				$('#anggaran_jenis_kegiatan').parent('div').removeClass('error');
				$('#anggaran_jenis_kegiatan_err').html('');
			}

			$('#submit-save').removeAttr('disabled');
			$('#submit-save').css('cursor', 'pointer');
		}else{
			formData.append('anggaran_nama_kegiatan', $('#anggaran_nama_kegiatan').val());
			formData.append('anggaran_jenis_kegiatan', $('#anggaran_jenis_kegiatan').val());
			let anggaran = reverseFormatRupiah($('#anggaran_besaran').val());
			formData.append('anggaran_besaran', anggaran);
			formData.append('anggaran_tahun_kegiatan', $('#anggaran_tahun_kegiatan').val());
			formData.append('anggaran_indikator_kegiatan', $('#indikator_kegiatan').val());
			formData.append('_token', $('#_token').val());

			$.ajax({
				url: '/anggaran-kegiatan/input',
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

	$('#form_anggaran_kegiatan_opd_update').submit(function (e) {
		e.preventDefault();
		var formData = new FormData();
		e.preventDefault();
		$('#submit-save').attr('disabled', 'true');
		$('#submit-save').css('cursor', 'not-allowed');
		$('#alert-indi-var').addClass('uk-hidden');
		$('#alert-indi-var').find('p').html('');
		var formData = new FormData();
		if($('#anggaran_nama_kegiatan').val() === ''){
			if($('#anggaran_nama_kegiatan').val() === ''){
				$('#anggaran_nama_kegiatan').parent('div').addClass('error');
				$('#anggaran_nama_kegiatan_err').html('Nama Jenis Kegiatan wajib di isi');
			}else{
				$('#anggaran_nama_kegiatan').parent('div').removeClass('error');
				$('#anggaran_nama_kegiatan_err').html('');
			}

			if($('#anggaran_besaran').val() === ''){
				$('#anggaran_besaran').parent('div').addClass('error');
				$('#anggaran_besaran_err').html('Nama Jenis Kegiatan wajib di isi');
			}else{
				$('#anggaran_besaran').parent('div').removeClass('error');
				$('#anggaran_besaran_err').html('');
			}

			if($('#anggaran_tahun_kegiatan').val() === ''){
				$('#anggaran_tahun_kegiatan').parent('div').addClass('error');
				$('#anggaran_tahun_kegiatan_err').html('Nama Jenis Kegiatan wajib di isi');
			}else{
				$('#anggaran_tahun_kegiatan').parent('div').removeClass('error');
				$('#anggaran_tahun_kegiatan_err').html('');
			}

			if($('#anggaran_jenis_kegiatan').val() === ''){
				$('#anggaran_jenis_kegiatan').parent('div').addClass('error');
				$('#anggaran_jenis_kegiatan_err').html('Nama Jenis Kegiatan wajib di isi');
			}else{
				$('#anggaran_jenis_kegiatan').parent('div').removeClass('error');
				$('#anggaran_jenis_kegiatan_err').html('');
			}

			$('#submit-save').removeAttr('disabled');
			$('#submit-save').css('cursor', 'pointer');
		}else{
			formData.append('anggaran_nama_kegiatan', $('#anggaran_nama_kegiatan').val());
			formData.append('anggaran_jenis_kegiatan', $('#anggaran_jenis_kegiatan').val());
			formData.append('anggaran_besaran', $('#anggaran_besaran').val());
			formData.append('anggaran_tahun_kegiatan', $('#anggaran_tahun_kegiatan').val());
			formData.append('_token', $('#_token').val());
			formData.append('idAnggaran', $('#submit-save').attr('data-id'));

			$.ajax({
				url: '/anggaran-kegiatan/update',
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


	$(document).on('click', '#del-anggaran-kegiatan', function(){
		$('#delAnggaranKegiatan').attr('data-id', $(this).attr('data-id'));
		$.UIkit.modal('#modal-del').show();
	});

	$('#delAnggaranKegiatan').on('click', function(){
		$.ajax({
			type: 'GET',
			url: '/anggaran-kegiatan/delete/'+ $(this).attr('data-id'),
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

	$('#filter_tahun_anggaran').on('change', function (e) {
		e.preventDefault();
		var loc = window.location;
		var url = loc.protocol + '//' + loc.host + loc.pathname;
		if($(this).val() !== ''){
			location.href = url+'?tahun='+$("#filter_tahun_anggaran").val();
		}else{
			location.href = url;
		}
	});

	var dengan_rupiah = document.getElementById('anggaran_besaran');
	dengan_rupiah.addEventListener('keyup', function(e)
	{
		dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
	});

	function formatRupiah(angka, prefix)
	{
		let number_string = angka.replace(/[^,\d]/g, '').toString(),
			split	= number_string.split(','),
			sisa 	= split[0].length % 3,
			rupiah 	= split[0].substr(0, sisa),
			ribuan 	= split[0].substr(sisa).match(/\d{3}/gi);
			
		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}
		
		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	}

	function reverseFormatRupiah(angka)
	{
		let number = angka.replace(/[Rp.]/g, '').toString();

		return number;
	}
});
