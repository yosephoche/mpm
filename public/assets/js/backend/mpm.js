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

	$('#nikKepRt').keypress(function (e) {
		if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	$('#jumAngKel').keypress(function (e) {
		if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	$('#kecamatan').on('change', function(){
		$('#kelurahan').empty();
		$('#kelurahan').append('<option value="">Pilih Kelurahan</option>');
		$.ajax({
			type: 'GET',
			url: '/getkelurahan/'+ $('#kecamatan').val(),
			success: function(data){
				msg = $.parseJSON(data);
				$.each(msg, function( key, value ) {
					$('#kelurahan').append('<option value="'+value.id_kelurahan+'">'+value.kelurahan+'</option>');
				});
			}
		});
	});

	$('#kelurahan').on('change', function(){
		if($('#nikKepRt').val() === '' || $('#kecamatan').val() === ''){
			$('#kelurahan').val('');
			$('.uk-modal-dialog').find('p').html('Lengkapi NIK Kepala Rumah Tangga');
			$.UIkit.modal('#modal-sudah-registrasi').show();
		}else{
			$.ajax({
				type: 'GET',
				url: '/getpesertaterdaftar/?nikkrt='+$('#nikKepRt').val()+'&kec='+$('#kecamatan').val()+'&kel='+$(this).val(),
				success: function(data){
					msg = $.parseJSON(data);
					if(msg.success === 0){
						$('.modal-content').find('p').html('Peserta sudah terdaftar sebagai peserta PPFM');
						$('#kelurahan').val('').change();
						$.UIkit.modal('#modal-sudah-registrasi').show();
					}
				}
			});
		}
	});

	$('#kecamatan-upd').on('change', function(){
		$('#kelurahan-upd').empty();
		$('#kelurahan-upd').append('<option value="">Pilih Kelurahan</option>');
		$.ajax({
			type: 'GET',
			url: '/getkelurahan/'+ $('#kecamatan-upd').val(),
			success: function(data){
				msg = $.parseJSON(data);
				$.each(msg, function( key, value ) {
					$('#kelurahan-upd').append('<option value="'+value.id_kelurahan+'">'+value.kelurahan+'</option>');
				});
			}
		});
	});

	$('#form-pendaftaran-mpm').submit(function(e){
		var formData = new FormData();
		e.preventDefault();
		var indi_var = {},
			asset_var = {},
			rt_var = {},
			arr_rt = [],
			arr_asset = [],
			arr_indi = [],
			status_indi = 1,
			status_rt = 1,
			status_asset = 1;

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

		var values1 = $('select[name^=spkt]').map(function() {
	        arr_indi.push(this.name);
	    }).get();

		$.each(arr_indi.unique(), function(i, el){
			if($('select[name='+el+']').val() === ''){
				status_indi = 0;
			}else{
				indi_var[$('select[name='+el+']').attr('id')] = $('select[name='+el+']').val();
			}
		});

		var values2 = $('input[data-status^=asset]').map(function() {
	        arr_asset.push(this.name);
	    }).get();

		$.each(arr_asset.unique(), function(i, el){
			if($('input[name='+el+']:checked').val() === undefined){
				status_asset = 0;
			}else{
				asset_var[el] = $('input[name='+el+']:checked').val();
			}
		});

		$('#submit-save').attr('disabled', 'true');
		$('#submit-save').css('cursor', 'not-allowed');
		$('#alert').addClass('uk-hidden');
		$('#alert').find('p').html('');
		if($('#nomorKk').val() === '' || $('#nomorKk').val().length < 16
			|| $('#nik').val() === '' || $('#nik').val().length < 16
			|| $('#namaLengkap').val() === '' || $('#jenisKelamin').val() === ''
			|| status_indi === 0 || $('#nikKepRt').val() === ''
			|| $('#nikKepRt').val().length < 16 || $('#namaKepRt').val() === ''
			|| $('#jenisKelKepRt').val() === '' || $('#umur').val() === ''
			|| $('#pekerjaanKepRt').val() === '' || $('#jumAngKel').val() === ''
			|| $('#namaJalan').val() === '' || $('#kecamatan').val() === '' || $('input[name=pendidikanart]').is(':checked') == false
			|| $('#kelurahan').val() === '' || status_rt === 0 || status_asset === 0
		){
			$('html, body').animate({scrollTop : 300},500);
			if($('#nomorKk').val() === ''){
				$('#nomorKk').addClass('error');
				$('#nomorKk_err').html('Nomor Kartu Keluarga wajib di isi');
			}else if($('#nomorKk').val().length < 16){
				$('#nomorKk').addClass('error');
				$('#nomorKk_err').html('Nomor Kartu Keluarga kurang dari 16 digit');
			}else{
				$('#nomorKk').removeClass('error');
				$('#nomorKk_err').html('');
			}

			if($('#nik').val() === ''){
				$('#nik').addClass('error');
				$('#nik_err').html('Nomor Induk Kependudukan wajib di isi');
			}else if($('#nik').val().length < 16){
				$('#nik').addClass('error');
				$('#nik_err').html('Nomor Induk Kependudukan kurang dari 16 digit');
			}else{
				$('#nik').removeClass('error');
				$('#nik_err').html('');
			}

			if($('#namaLengkap').val() === ''){
				$('#namaLengkap').addClass('error');
				$('#namaLengkap_err').html('Nama Lengkap wajib di isi');
			}else{
				$('#namaLengkap').removeClass('error');
				$('#namaLengkap_err').html('');
			}

			if($('#jenisKelamin').val() === ''){
				$('#jenisKelamin').addClass('error');
				$('#jenisKelamin_err').html('Jenis Kelamin wajib di isi');
			}else{
				$('#jenisKelamin').removeClass('error');
				$('#jenisKelamin_err').html('');
			}

			$.each(arr_indi.unique(), function(i, el){
				$('select[name='+el+']').parent('div').removeClass('error');
				$('div.error[id='+el+'_err]').html('');
				if($('select[name='+el+']').val() === ''){
					$('select[name='+el+']').parent('div').addClass('error');
					$('div.error[id='+el+'_err]').html('Mohon Lengkapi Data');
				}
			});

			if($('#nikKepRt').val() === ''){
				$('#nikKepRt').addClass('error');
				$('#nikKepRt_err').html('Nomor Induk Kependudukan Kepala RuTa wajib di isi');
			}else if($('#nikKepRt').val().length < 16){
				$('#nikKepRt').addClass('error');
				$('#nikKepRt_err').html('Nomor Induk Kependudukan Kepala RuTa kurang dari 16 digit');
			}else{
				$('#nikKepRt').removeClass('error');
				$('#nikKepRt_err').html('');
			}

			if($('#namaKepRt').val() === ''){
				$('#namaKepRt').addClass('error');
				$('#namaKepRt_err').html('Nama Kepala RuTa wajib di isi');
			}else{
				$('#namaKepRt').removeClass('error');
				$('#namaKepRt_err').html('');
			}

			if($('#jenisKelKepRt').val() === ''){
				$('#jenisKelKepRt').addClass('error');
				$('#jenisKelKepRt_err').html('Jenis Kelamin Kepala RuTa wajib di isi');
			}else{
				$('#jenisKelKepRt').removeClass('error');
				$('#jenisKelKepRt_err').html('');
			}

			if($('#umur').val() === ''){
				$('#umur').addClass('error');
				$('#umur_err').html('Umur Kepala RuTa wajib di isi');
			}else{
				$('#umur').removeClass('error');
				$('#umur_err').html('');
			}

			if($('#pekerjaanKepRt').val() === ''){
				$('#pekerjaanKepRt').parent('div').addClass('error');
				$('#pekerjaanKepRt_err').html('Status Pekerjaan Kepala RuTa wajib di isi');
			}else{
				$('#pekerjaanKepRt').parent('div').removeClass('error');
				$('#pekerjaanKepRt_err').html('');
			}

			if($('#jumAngKel').val() === ''){
				$('#jumAngKel').addClass('error');
				$('#jumAngKel_err').html('Jumlah Anggota Keluarga wajib di isi');
			}else{
				$('#jumAngKel').removeClass('error');
				$('#jumAngKel_err').html('');
			}

			if($('#namaJalan').val() === ''){
				$('#namaJalan').addClass('error');
				$('#namaJalan_err').html('Nama Jalan wajib di isi');
			}else{
				$('#namaJalan').removeClass('error');
				$('#namaJalan_err').html('');
			}

			if($('#kecamatan').val() === ''){
				$('#kecamatan').parent('div').addClass('error');
				$('#kecamatan_err').html('Kecamatan wajib di isi');
			}else{
				$('#kecamatan').parent('div').removeClass('error');
				$('#kecamatan_err').html('');
			}

			if($('#kelurahan').val() === ''){
				$('#kelurahan').parent('div').addClass('error');
				$('#kelurahan_err').html('Kelurahan wajib di isi');
			}else{
				$('#kelurahan').parent('div').removeClass('error');
				$('#kelurahan_err').html('');
			}

			if($('input[name=pendidikanart]').is(':checked') == false){
				$('#pendidikanart_err').html('Data wajib di isi');
			}else{
				$('#pendidikanart_err').html('');
			}

			$.each(arr_rt.unique(), function(i, el){
				$('div.error[id='+el+'_err]').html('');
				if($('input[name='+el+']:checked').val() === undefined){
					$('div.error[id='+el+'_err]').html('Mohon Lengkapi Data');
				}
			});

			$.each(arr_asset.unique(), function(i, el){
				$('div.error[id='+el+'_err]').html('');
				if($('input[name='+el+']:checked').val() === undefined){
					$('div.error[id='+el+'_err]').html('Mohon Lengkapi Data');
				}
			});
			$('#submit-save').removeAttr('disabled');
			$('#submit-save').css('cursor', 'pointer');
		}else{

			formData.append('nomorKk', $('#nomorKk').val());
			formData.append('nik', $('#nik').val());
			formData.append('namaLengkap', $('#namaLengkap').val());
			formData.append('jenisKelamin', $('#jenisKelamin').val());
			formData.append('indiVar', JSON.stringify(indi_var));
			formData.append('nikKepRt', $('#nikKepRt').val());
			formData.append('namaKepRt', $('#namaKepRt').val());
			formData.append('jenisKelKepRt', $('#jenisKelKepRt').val());
			formData.append('umur', $('#umur').val());
			formData.append('pekerjaanKepRt', $('#pekerjaanKepRt').val());
			formData.append('jumAngKel', $('#jumAngKel').val());
			formData.append('namaJalan', $('#namaJalan').val());
			formData.append('kecamatan', $('#kecamatan').val());
			formData.append('kelurahan', $('#kelurahan').val());
			formData.append('pendidikanart', $('input[name=pendidikanart]:checked').val());
			formData.append('rtVar', JSON.stringify(rt_var));
			formData.append('assetVar', JSON.stringify(asset_var));
			formData.append('_token', $('#_token').val());

			$.ajax({
				url: '/mpm/registrasi',
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


	$('#form-update-mpm').submit(function(e){
		var formData = new FormData();
		e.preventDefault();
		var indi_var = {},
			asset_var = {},
			rt_var = {},
			arr_rt = [],
			arr_asset = [],
			arr_indi = [],
			status_indi = 1,
			status_rt = 1;
			status_asset = 1;

		var values = $('input[data-status^=rt]').map(function() {
	        arr_rt.push(this.name);
	    }).get();

		$.each(arr_rt.unique(), function(i, el){
			if($('input[name='+el+']:checked').val() === undefined){
				status_rt = 0;
			}else{
				rt_var['datart.0.'+el] = $('input[name='+el+']:checked').val();
			}
		});

		var values1 = $('select[name^=spkt]').map(function() {
	        arr_indi.push(this.name);
	    }).get();

		$.each(arr_indi.unique(), function(i, el){
			if($('select[name='+el+']').val() === ''){
				status_indi = 0;
			}else{
				indi_var['pendaftar.0.'+$('select[name='+el+']').attr('id')] = $('select[name='+el+']').val();
			}
		});

		var values2 = $('input[data-status^=asset]').map(function() {
	        arr_asset.push(this.name);
	    }).get();

		$.each(arr_asset.unique(), function(i, el){
			if($('input[name='+el+']:checked').val() === undefined){
				status_asset = 0;
			}else{
				asset_var['asset.0.'+el] = $('input[name='+el+']:checked').val();
			}
		});

		$('#update-save').attr('disabled', 'true');
		$('#update-save').css('cursor', 'not-allowed');
		$('#alert').addClass('uk-hidden');
		$('#alert').find('p').html('');
		if($('#nomorKk').val() === '' || $('#nomorKk').val().length < 16
			|| $('#nik').val() === '' || $('#nik').val().length < 16
			|| $('#namaLengkap').val() === '' || $('#jenisKelamin').val() === ''
			|| status_indi === 0 || $('#nikKepRt').val() === ''
			|| $('#nikKepRt').val().length < 16 || $('#namaKepRt').val() === ''
			|| $('#jenisKelKepRt').val() === '' || $('#umur').val() === '' || $('input[name=pendidikanart]').is(':checked') == false
			|| $('#pekerjaanKepRt').val() === '' || $('#jumAngKel').val() === ''
			|| $('#namaJalan').val() === '' || $('#kecamatan-upd').val() === ''
			|| $('#kelurahan-upd').val() === '' || status_rt === 0 || status_asset === 0
		){
			$('html, body').animate({scrollTop : 300},500);
			if($('#nomorKk').val() === ''){
				$('#nomorKk').addClass('error');
				$('#nomorKk_err').html('Nomor Kartu Keluarga wajib di isi');
			}else if($('#nomorKk').val().length < 16){
				$('#nomorKk').addClass('error');
				$('#nomorKk_err').html('Nomor Kartu Keluarga kurang dari 16 digit');
			}else{
				$('#nomorKk').removeClass('error');
				$('#nomorKk_err').html('');
			}

			if($('#nik').val() === ''){
				$('#nik').addClass('error');
				$('#nik_err').html('Nomor Induk Kependudukan wajib di isi');
			}else if($('#nik').val().length < 16){
				$('#nik').addClass('error');
				$('#nik_err').html('Nomor Induk Kependudukan kurang dari 16 digit');
			}else{
				$('#nik').removeClass('error');
				$('#nik_err').html('');
			}

			if($('#namaLengkap').val() === ''){
				$('#namaLengkap').addClass('error');
				$('#namaLengkap_err').html('Nama Lengkap wajib di isi');
			}else{
				$('#namaLengkap').removeClass('error');
				$('#namaLengkap_err').html('');
			}

			if($('#jenisKelamin').val() === ''){
				$('#jenisKelamin').addClass('error');
				$('#jenisKelamin_err').html('Jenis Kelamin wajib di isi');
			}else{
				$('#jenisKelamin').removeClass('error');
				$('#jenisKelamin_err').html('');
			}

			$.each(arr_indi.unique(), function(i, el){
				$('select[name='+el+']').parent('div').removeClass('error');
				$('div.error[id='+el+'_err]').html('');
				if($('select[name='+el+']').val() === ''){
					$('select[name='+el+']').parent('div').addClass('error');
					$('div.error[id='+el+'_err]').html('Mohon Lengkapi Data');
				}
			});

			if($('#nikKepRt').val() === ''){
				$('#nikKepRt').addClass('error');
				$('#nikKepRt_err').html('Nomor Induk Kependudukan Kepala RuTa wajib di isi');
			}else if($('#nikKepRt').val().length < 16){
				$('#nikKepRt').addClass('error');
				$('#nikKepRt_err').html('Nomor Induk Kependudukan Kepala RuTa kurang dari 16 digit');
			}else{
				$('#nikKepRt').removeClass('error');
				$('#nikKepRt_err').html('');
			}

			if($('#namaKepRt').val() === ''){
				$('#namaKepRt').addClass('error');
				$('#namaKepRt_err').html('Nama Kepala RuTa wajib di isi');
			}else{
				$('#namaKepRt').removeClass('error');
				$('#namaKepRt_err').html('');
			}

			if($('#jenisKelKepRt').val() === ''){
				$('#jenisKelKepRt').addClass('error');
				$('#jenisKelKepRt_err').html('Jenis Kelamin Kepala RuTa wajib di isi');
			}else{
				$('#jenisKelKepRt').removeClass('error');
				$('#jenisKelKepRt_err').html('');
			}

			if($('#ttlKepRt').val() === ''){
				$('#ttlKepRt').addClass('error');
				$('#ttlKepRt_err').html('Bulan & Tahun Lahir Kepala RuTa wajib di isi');
			}else{
				$('#ttlKepRt').removeClass('error');
				$('#ttlKepRt_err').html('');
			}

			if($('#pekerjaanKepRt').val() === ''){
				$('#pekerjaanKepRt').parent('div').addClass('error');
				$('#pekerjaanKepRt_err').html('Status Pekerjaan Kepala RuTa wajib di isi');
			}else{
				$('#pekerjaanKepRt').parent('div').removeClass('error');
				$('#pekerjaanKepRt_err').html('');
			}

			if($('#jumAngKel').val() === ''){
				$('#jumAngKel').addClass('error');
				$('#jumAngKel_err').html('Jumlah Anggota Keluarga wajib di isi');
			}else{
				$('#jumAngKel').removeClass('error');
				$('#jumAngKel_err').html('');
			}

			if($('#namaJalan').val() === ''){
				$('#namaJalan').addClass('error');
				$('#namaJalan_err').html('Nama Jalan wajib di isi');
			}else{
				$('#namaJalan').removeClass('error');
				$('#namaJalan_err').html('');
			}

			if($('#kecamatan-upd').val() === ''){
				$('#kecamatan-upd').parent('div').addClass('error');
				$('#kecamatan_err').html('Kecamatan wajib di isi');
			}else{
				$('#kecamatan-upd').parent('div').removeClass('error');
				$('#kecamatan_err').html('');
			}

			if($('#kelurahan-upd').val() === ''){
				$('#kelurahan-upd').parent('div').addClass('error');
				$('#kelurahan_err').html('Kelurahan wajib di isi');
			}else{
				$('#kelurahan-upd').parent('div').removeClass('error');
				$('#kelurahan_err').html('');
			}

			if($('input[name=pendidikanart]').is(':checked') == false){
				$('#pendidikanart_err').html('Data wajib di isi');
			}else{
				$('#pendidikanart_err').html('');
			}

			$.each(arr_rt.unique(), function(i, el){
				$('div.error[id='+el+'_err]').html('');
				if($('input[name='+el+']:checked').val() === undefined){
					$('div.error[id='+el+'_err]').html('Mohon Lengkapi Data');
				}
			});

			$.each(arr_asset.unique(), function(i, el){
				$('div.error[id='+el+'_err]').html('');
				if($('input[name='+el+']:checked').val() === undefined){
					$('div.error[id='+el+'_err]').html('Mohon Lengkapi Data');
				}
			});

			$('#update-save').removeAttr('disabled');
			$('#update-save').css('cursor', 'pointer');
		}else{

			formData.append('nomorKk', $('#nomorKk').val());
			formData.append('nik', $('#nik').val());
			formData.append('namaLengkap', $('#namaLengkap').val());
			formData.append('jenisKelamin', $('#jenisKelamin').val());
			formData.append('indiVar', JSON.stringify(indi_var));
			formData.append('nikKepRt', $('#nikKepRt').val());
			formData.append('namaKepRt', $('#namaKepRt').val());
			formData.append('jenisKelKepRt', $('#jenisKelKepRt').val());
			formData.append('umur', $('#umur').val());
			formData.append('pendidikanart', $('input[name=pendidikanart]:checked').val());
			formData.append('pekerjaanKepRt', $('#pekerjaanKepRt').val());
			formData.append('jumAngKel', $('#jumAngKel').val());
			formData.append('namaJalan', $('#namaJalan').val());
			formData.append('kecamatan', $('#kecamatan-upd').val());
			formData.append('kelurahan', $('#kelurahan-upd').val());
			formData.append('rtVar', JSON.stringify(rt_var));
			formData.append('assetVar', JSON.stringify(asset_var));
			formData.append('_token', $('#_token').val());
			formData.append('idpeserta', $('#update-save').attr('data-id'));

			$.ajax({
				url: '/mpm/update',
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
						$('#update-save').removeAttr('disabled');
						$('#update-save').css('cursor', 'pointer');
						setTimeout(function(){
							location.reload(true);
						}, 2000);
					}else{
						$('#alert').removeClass('uk-alert-success');
						$('#alert').removeClass('uk-hidden');
						$('#alert').addClass('uk-alert-warning');
						$('#alert').find('p').html(msg.message);
						$('#update-save').removeAttr('disabled');
						$('#update-save').css('cursor', 'pointer');
					}
				},
				error: function(response){
					$('#alert').removeClass('uk-alert-success');
					$('#alert').removeClass('uk-hidden');
					$('#alert').addClass('uk-alert-warning');
					$('#alert').find('p').html('Terjadi kesalahan. Silahkan ulangi beberapa saat lagi');
					$('#update-save').removeAttr('disabled');
					$('#update-save').css('cursor', 'pointer');
				}
			});
		}
	});

	$(document).on('click', '#del-peserta', function(){
        $('#delPeserta').attr('data-id', $(this).attr('data-id'));
        $.UIkit.modal('#modal-del').show();
    });

    $('#delPeserta').on('click', function(){
        $.ajax({
            type: 'GET',
            url: '/mpm/delete/'+ $(this).attr('data-id'),
            success: function(data){
                msg = $.parseJSON(data);
                if(msg.success == 1){
                    $('#alert-modal').removeClass('uk-alert-warning');
                    $('#alert-modal').removeClass('uk-hidden');
                    $('#alert-modal').addClass('uk-alert-success');
                    $('#alert-modal').find('p').html(msg.message);
                    setTimeout(function(){
                        location.reload(true);
                    }, 1000);
                }else{
                    $('#alert-modal').removeClass('uk-alert-success');
                    $('#alert-modal').removeClass('uk-hidden');
                    $('#alert-modal').addClass('uk-alert-warning');
                    $('#alert-modal').find('p').html(msg.message);
                }
            },
            error : function(response){
                $('#alert-modal').removeClass('uk-alert-success');
                $('#alert-modal').removeClass('uk-hidden');
                $('#alert-modal').addClass('uk-alert-warning');
                $('#alert-modal').find('p').html('Terjadi Kesalahan. Silahkan ulangi beberapa saat lagi.');
            }
        });
    });
});
