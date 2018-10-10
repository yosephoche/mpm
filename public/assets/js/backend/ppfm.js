$(document).ready(function(){

	var lists = [];
	var count = $('#fs-page-iv').find('ol > li').length;
	var count2 = $('#fs-page-iv-2').find('ol > li').length;

	if(sidebar == 'sidebar-fppfm-sudah'){
		$('.m-sidebar').find('.uk-active').removeClass('uk-active');
		$('#sidebar-fppfm').addClass('uk-active');
		$('#sidebar-fppfm-sudah').addClass('uk-active');
	}else if(sidebar == 'sidebar-fppfm-belum'){
		$('.m-sidebar').find('.uk-active').removeClass('uk-active');
		$('#sidebar-fppfm').addClass('uk-active');
		$('#sidebar-fppfm-belum').addClass('uk-active');
	}

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

	$('#page-3 .f-tambah-data').on('click', function() {
		var formData = new FormData(), kdp = $(this).attr('data-kdp'),
			indi_var = {},
			arr_indi = [],
			status_indi = 1;

		var values = $('input[data-status^=individu]').map(function() {
			arr_indi.push(this.name);
		}).get();

		var values = $('select[data-status^=individu]').map(function() {
			arr_indi.push(this.name);
		}).get();

		$.each(arr_indi.unique(), function(i, el){
			if($('input[name='+el+']').attr('type') == 'checked'){
				if($('input[name='+el+']:checked').val() !== undefined){
					indi_var[el] = $('input[id='+el+']:checked').val();
				}
			}else if($('input[name='+el+']').attr('type') == 'text'){
				indi_var[el] = $('input[id='+el+']').val();
			}else{
				indi_var[el] = $('select[id='+el+']').val();
			}
		});

		if($('#nik').val() == '' || $('#nik').val().length < 16
		|| $('#nama').val() == '' 
		){
			$('html, body').animate({scrollTop : 500},500);

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
			if($('#nama').val() === ''){
				$('#nama').addClass('error');
				$('#nama_err').html('Nama anggota rumah tangga wajib di isi');
			}else{
				$('#nama').removeClass('error');
				$('#nama_err').html('');
			}

		}else{
			formData.append('kodepeserta', $(this).attr('data-kdp'));
			formData.append('nik', $('#nik').val());
			formData.append('nama', $('#nama').val());
			formData.append('indiVar', JSON.stringify(indi_var));
			formData.append('_token', $('#_token').val());
			
			$.ajax({
				url: '/ppfm/registrasi/individu',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data) {
					msg = $.parseJSON(data);
					if(msg.success == 1){
						$('#alert-add-art').removeClass('uk-alert-warning');
						$('#alert-add-art').removeClass('uk-hidden');
						$('#alert-add-art').addClass('uk-alert-success');
						$('#alert-add-art').find('p').html(msg.message);
						setTimeout(function(){
							$('#alert-add-art').removeClass('uk-alert-warning');
							$('#alert-add-art').addClass('uk-hidden');
							$('#alert-add-art').removeClass('uk-alert-success');
							$('#alert-add-art').find('p').html('');
							fieldSet('fs-page-iv', kdp, $('#nik').val());
						}, 1500);

					}else{
						$('#alert-add-art').removeClass('uk-alert-success');
						$('#alert-add-art').removeClass('uk-hidden');
						$('#alert-add-art').addClass('uk-alert-warning');
						$('#alert-add-art').find('p').html(msg.message);

						setTimeout(function(){
							$('#alert-add-art').removeClass('uk-alert-warning');
							$('#alert-add-art').addClass('uk-hidden');
							$('#alert-add-art').removeClass('uk-alert-success');
							$('#alert-add-art').find('p').html('');
						}, 2000);
					}
				},
				error: function(response){
					$('#alert-add-art').removeClass('uk-alert-success');
					$('#alert-add-art').removeClass('uk-hidden');
					$('#alert-add-art').addClass('uk-alert-warning');
					$('#alert-add-art').find('p').html('Terjadi kesalahan. Silahkan ulangi beberapa saat lagi');

				}
			});

		}
	});

	$('#next-rt').on('click', function(){
		/*var asset_var = {},
			rt_var = {},
			arr_rt = [],
			arr_asset = [],
			status_rt = 1,
			status_asset = 1;

		var values = $('input[id^=rt]').map(function() {
			arr_rt.push(this.name);
		}).get();

		$.each(arr_rt.unique(), function(i, el){
			if($('input[name='+el+']').attr('type') == 'text'){
				if($('input[name='+el+']').val() !== ''){
					rt_var[el] = $('input[name='+el+']').val();
				}else{
					status_rt = 0;
				}
			}else{
				if(el.split('-').length === 2){
					if($('input[name='+el+']:checked').val() !== undefined){
						rt_var[el.split('-')[0]+'-1'] = $('input[name='+el+']:checked').val();
					}
				}else{
					if($('input[name='+el+']:checked').val() !== undefined){
						rt_var[el] = $('input[name='+el+']:checked').val();
					}else{
						status_rt = 0;
					}
				}
			}
		});*/

		if($('#sls').val() === '' || $('#no-kk').val() === '' || $('#no-kk').val().length < 16
			|| $('#jum-kel').val() === ''
		){

			if($('#no-kk').val() === ''){
				$('#no-kk').addClass('error');
				$('#no-kk_err').html('Nomor Kartu Keluarga wajib di isi');
			}else if($('#no-kk').val().length < 16){
				$('#no-kk').addClass('error');
				$('#no-kk_err').html('Nomor Kartu Keluarga kurang dari 16 digit');
			}else{
				$('#no-kk').removeClass('error');
				$('#no-kk_err').html('');
			}

			if($('#sls').val() === ''){
				$('#sls').addClass('error');
				$('#sls_err').html('Nama SLS wajib di isi');
			}else{
				$('#sls').removeClass('error');
				$('#sls_err').html('');
			}

			if($('#jum-kel').val() === ''){
				$('#jum-kel').addClass('error');
				$('#jum-kel_err').html('Nama Lengkap wajib di isi');
			}else{
				$('#jum-kel').removeClass('error');
				$('#jum-kel_err').html('');
			}

			/*$.each(arr_rt.unique(), function(i, el){
				if($('input[name='+el+']').attr('type') === 'radio'){
					if($('input[name='+el+'][type=radio]:checked').val() === undefined){
						$('div.error[id='+el+'_err]').html('Mohon Lengkapi Data');
					}else{
						$('div.error[id='+el+'_err]').html('');
					}
				}else{
					if($('input[name='+el+'][type=text]').val() === ''){
						$('div.error[id='+el+'_err]').html('Mohon Lengkapi Data');
					}else{
						$('div.error[id='+el+'_err]').html('');
					}
				}
			});*/

			
		}else{
			gNext(this);		
		}
	});

	$('#next-asset').on('click', function(){
		/*var asset_var = {},
			arr_asset = [],
			status_asset = 1;

		var values = $('input[id^=asset]').map(function() {
			arr_asset.push(this.name);
		}).get();

		$.each(arr_asset.unique(), function(i, el){
			if($('input[name='+el+']').attr('type') == 'text'){
				if(el.split('-').length !== 2){
					if($('input[name='+el+']').val() !== ''){
						asset_var[el] = $('input[name='+el+']').val();
					}else{
						status_asset = 0;
					}
				}
			}else{
				if(el.split('-').length === 2){
					if($('input[name='+el+']:checked').val() !== undefined){
						asset_var[el.split('-')[0]+'-1'] = $('input[name='+el+']:checked').val();
					}
				}else{
					if($('input[name='+el+']:checked').val() !== undefined){
						asset_var[el] = $('input[name='+el+']:checked').val();
					}else{
						status_asset = 0;
					}
				}
			}
		});*/

		/*if(status_asset === 0){
			$.each(arr_asset.unique(), function(i, el){
				if($('input[name='+el+']').attr('type') === 'radio'){
					if($('input[name='+el+'][type=radio]:checked').val() === undefined){
						$('div.error[id='+el+'_err]').html('Mohon Lengkapi Data');
					}else{
						$('div.error[id='+el+'_err]').html('');
					}
				}else{
					if($('input[name='+el+'][type=text]').val() === ''){
						$('div.error[id='+el+'_err]').html('Mohon Lengkapi Data');
					}else{
						$('div.error[id='+el+'_err]').html('');
					}
				}
			});
		}else{*/
			gNext(this);		
		/*}*/
	});

	$('#next-art').on('click', function(){
		gNext(this);
	});
	$('#prev-asset, #prev-art, #prev-tanggungan').on('click', function(){
		gPrev(this);
	});

	$('#page-4 .f-tambah-data').on('click', function() {
		var formData = new FormData(), kdp = $(this).attr('data-kdp');

		if($('#nik-t-iv').val() == '' || $('#nik-t-iv').val().length < 16
		|| $('#nama-t-iv').val() == '' || $('#alamat-t-iv').val() == ''
		|| $('#nama-sekolah-t-iv').val() == '' || $('#nisn-t-iv').val() == ''
		){
			$('html, body').animate({scrollTop : 500},500);
			if($('#nik-t-iv').val() === ''){
				$('#nik-t-iv').addClass('error');
				$('#nik-t-iv_err').html('Nomor Induk Kependudukan wajib di isi');
			}else if($('#nik-t-iv').val().length < 16){
				$('#nik-t-iv').addClass('error');
				$('#nik-t-iv_err').html('Nomor Induk Kependudukan kurang dari 16 digit');
			}else{
				$('#nik-t-iv').removeClass('error');
				$('#nik-t-iv_err').html('');
			}

			if($('#nama-t-iv').val() === ''){
				$('#nama-t-iv').addClass('error');
				$('#nama-t-iv_err').html('Nama anggota rumah tangga wajib di isi');
			}else{
				$('#nama-t-iv').removeClass('error');
				$('#nama-t-iv_err').html('');
			}

			if($('#alamat-t-iv').val() === ''){
				$('#alamat-t-iv').addClass('error');
				$('#alamat-t-iv_err').html('Alamat wajib di isi');
			}else{
				$('#alamat-t-iv').removeClass('error');
				$('#alamat-t-iv_err').html('');
			}

			if($('#nama-sekolah-t-iv').val() === ''){
				$('#nama-sekolah-t-iv').addClass('error');
				$('#nama-sekolah-t-iv_err').html('Nama sekolah wajib di isi');
			}else{
				$('#nama-sekolah-t-iv').removeClass('error');
				$('#nama-sekolah-t-iv_err').html('');
			}
			if($('#nisn-t-iv').val() === ''){
				$('#nisn-t-iv').addClass('error');
				$('#nisn-t-iv_err').html('NISN wajib di isi');
			}else{
				$('#nisn-t-iv').removeClass('error');
				$('#nisn-t-iv_err').html('');
			}
		}else{
			formData.append('kodepeserta', $(this).attr('data-kdp'));
			formData.append('nik', $('#nik-t-iv').val());
			formData.append('nama', $('#nama-t-iv').val());
			formData.append('alamat', $('#alamat-t-iv').val());
			formData.append('namasekolah', $('#nama-sekolah-t-iv').val());
			formData.append('nisn', $('#nisn-t-iv').val());
			formData.append('_token', $('#_token').val());

			$.ajax({
				url: '/ppfm/registrasi/individu/tanggungan',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data) {
					msg = $.parseJSON(data);
					if(msg.success == 1){
						$('#alert-add-tanggungan').removeClass('uk-alert-warning');
						$('#alert-add-tanggungan').removeClass('uk-hidden');
						$('#alert-add-tanggungan').addClass('uk-alert-success');
						$('#alert-add-tanggungan').find('p').html(msg.message);
						setTimeout(function(){
							$('#alert-add-tanggungan').removeClass('uk-alert-warning');
							$('#alert-add-tanggungan').addClass('uk-hidden');
							$('#alert-add-tanggungan').removeClass('uk-alert-success');
							$('#alert-add-tanggungan').find('p').html('');
							fieldSet2('fs-page-iv-2', kdp, $('#nik-t-iv').val());
						}, 1500);

					}else{
						$('#alert-add-tanggungan').removeClass('uk-alert-success');
						$('#alert-add-tanggungan').removeClass('uk-hidden');
						$('#alert-add-tanggungan').addClass('uk-alert-warning');
						$('#alert-add-tanggungan').find('p').html(msg.message);

						setTimeout(function(){
							$('#alert-add-tanggungan').removeClass('uk-alert-warning');
							$('#alert-add-tanggungan').addClass('uk-hidden');
							$('#alert-add-tanggungan').removeClass('uk-alert-success');
							$('#alert-add-tanggungan').find('p').html('');
						}, 2000);
					}
				},
				error: function(response){
					$('#alert-add-tanggungan').removeClass('uk-alert-success');
					$('#alert-add-tanggungan').removeClass('uk-hidden');
					$('#alert-add-tanggungan').addClass('uk-alert-warning');
					$('#alert-add-tanggungan').find('p').html('Terjadi kesalahan. Silahkan ulangi beberapa saat lagi');

				}
			});

		}
	});

	function fieldSet(fs, kodepeserta, nik) {
		var list = $('#'+fs+' > li > ol');
		var raw =     '<li class="uk-parent">'+
							'<a href="#"></a><i  id="delete-item-art" data-kdp="'+kodepeserta+'" data-nik="'+nik+'" class="uk-icon-close delete-item"></i>'+
							'<ul class="uk-nav-sub">'+
								'<li>'+
								'</li>'+
								'<li>'+
									'<div class="uk-clearfix">'+
										'<div class="uk-float-right">'+
											'<button type="button" id="btn-save" data-id="'+count+'" data-kdp="'+kodepeserta+'" class="button-save">Simpan</button>'+
										'</div>'+
									'</div>'+
								'</li>'+
							'</ul>'+
						'</li>';
		list.append(raw);
		$('#'+fs).next().find('input, select').each(function(key, value) {
			if ($(value).is(':text')) {
				$(value).attr('value', $(value).val());
			} else if ($(value).is('select')) {
				$(value).attr('value', $(value).val());

				$(value).find('option[value="'+ $(value).val() +'"]').attr('selected', true);
			}
		});
		var clone = $('#'+fs).next().clone();
		var item = $('#'+fs+' > li > ol > li');
		parsing(clone, '#'+fs, '_');
		$('#'+fs).next().find('input, select').each(function(key, value) {
            if ($(value).is(':text')) {
                $(value).val('').prop('value', '');
            } else if ($(value).is('select')) {
                $(value).val($(value).find('option').first().val()).change();
                $(value).find('option[selected="selected"]').removeAttr('selected');
            } else if ($(value).is(':radio') || $(value).is(':checkbox')) {
                $(value).prop('checked', false);
            }
        });
	}


	function fieldSet2(fs, kodepeserta, nik) {
		var list = $('#'+fs+' > li > ol');
		var raw =     '<li class="uk-parent">'+
							'<a href="#"></a><i  id="delete-item-tanggungan" data-kdp="'+kodepeserta+'" data-nik="'+nik+'" class="uk-icon-close delete-item"></i>'+
							'<ul class="uk-nav-sub">'+
								'<li>'+
								'</li>'+
								'<li>'+
									'<div class="uk-clearfix">'+
										'<div class="uk-float-right">'+
											'<button type="button" id="btn-save-tanggungan" data-id="'+count2+'" data-kdp="'+kodepeserta+'" class="button-save">Simpan</button>'+
										'</div>'+
									'</div>'+
								'</li>'+
							'</ul>'+
						'</li>';
		list.append(raw);
		var clone = $('#'+fs).next().clone();
		var item = $('#'+fs+' > li > ol > li');
		parsing2(clone, '#'+fs, '_');
		$('#'+fs).next().find('input, select').each(function(key, value) {
		$(value).val('').attr('value', '');
		if ($(value).is('select')) {
			$(value).find('option[selected="selected"]').removeAttr('selected');
			$(value).find('option[value=""]').attr('selected', true);
		}
		});
	}

	function parsing(el, page, c) {
		var ic = 0;

		el.find('input, select').attr('id', function(i, value) {
			return value + c + count;
		});

		el.find('input, select').attr('data-status', function(i, value) {
			return 'individu' + c + count;
		});

		el.find('.uk-alert').attr('id', function(i, value) {
			return 'alert-add-art_'+count;
		});

		el.find('.error').attr('id', function(i, value) {
			return value.split('_')[0]+'_'+count+'_err';
		});

		var check = true;

		if (check) {
			$(''+page+' > li > ol > li > ul > li').first().append(el);
			$(''+page+' > li > ol > li').each(function(key, value) {
				var n = $('[id="nama_'+ key +'"]').val() + ' ( ' +  $('[id="nik_'+ key +'"]').val() + ')';
				$(value).children('a').text(n);

			});
			count++;
		} else {
			$(''+page+' > li > ol > li:last-child').remove();
			el.remove();
		}
	}

	/*$('#next-rt').on('click', function(){
		next(this);

	});*/

	function parsing2(el, page, c) {
		var ic = 0;

		el.find('input, select').attr('id', function(i, value) {
			return value + c + count2;
		});

		el.find('.uk-alert').attr('id', function(i, value) {
			return 'alert-add-art_'+count2;
		});

		el.find('.error').attr('id', function(i, value) {
			return value.split('_')[0]+'_'+count2+'_err';
		});

		var check = true;

		if (check) {
			$(''+page+' > li > ol > li > ul > li').first().append(el);
			$(''+page+' > li > ol > li').each(function(key, value) {
				var n = $('[id="nama-t-iv_' + key +'"]').val() + ' ( ' +  $('[id="nik-t-iv_' + key +'"]').val() + ' )';
				$(value).children('a').text(n);
			});

			count2++;
		} else {
			$(''+page+' > li > ol > li:last-child').remove();
			el.remove();
		}
	}

	$('ol').on('click', '#delete-item-art', function(e) {
		$.ajax({
			type: 'GET',
			url: '/delete/pesertaindividu?nik='+$(this).attr('data-nik')+'&kode='+$(this).attr('data-kdp'),
			success: function(data){
				msg = $.parseJSON(data);
				if(msg.success === 1){
					$(e.currentTarget.offsetParent).remove();
					var i = 0, ic = 0;
					count--;
					$('#fs-page-iv > li > ol > li').each(function(key, value) {
						$('#fs-page-iv > li > ol > li:eq('+i+')').find('input, select').attr('id', function(idx, value) {
							return value.split('_')[0] + '_' + i;
						});
						$('#fs-page-iv > li > ol > li:eq('+i+')').find('input[type=checkbox]').attr('name', function(idx, value) {
							return value.split('_')[0] + '_' + i;
						});
						$('#fs-page-iv > li > ol > li:eq('+i+')').find('#btn-save').attr('data-id', function(idx, value) {
							return i;
						});

						$('#fs-page-iv > li > ol > li:eq('+i+')').find('.uk-alert').attr('id', function(idx, value) {
							return 'alert-add-art_'+i;
						});

						$('#fs-page-iv > li > ol > li:eq('+i+')').find('.error').attr('id', function(idx, value) {
							return value.split('_')[0]+'_'+i+'_err';
						});

						i++;
					});
				}
			}
		});
	});

	$('ol').on('click', '#delete-item-tanggungan', function(e) {
		$.ajax({
			type: 'GET',
			url: '/delete/pesertatanggungan?nik='+$(this).attr('data-nik')+'&kode='+$(this).attr('data-kdp'),
			success: function(data){
				msg = $.parseJSON(data);
				if(msg.success === 1){
					$(e.currentTarget.offsetParent).remove();
					var i = 0, ic = 0;
					count--;
					$('#fs-page-iv-2 > li > ol > li').each(function(key, value) {
						$('#fs-page-iv-2 > li > ol > li:eq('+i+')').find('input, select').attr('id', function(idx, value) {
							return value.split('_')[0] + '_' + i;
						});

						$('#fs-page-iv-2 > li > ol > li:eq('+i+')').find('#btn-save').attr('data-id', function(idx, value) {
							return i;
						});

						$('#fs-page-iv-2 > li > ol > li:eq('+i+')').find('.uk-alert').attr('id', function(idx, value) {
							return 'alert-add-tanggungan_'+i;
						});

						$('#fs-page-iv-2 > li > ol > li:eq('+i+')').find('.error').attr('id', function(idx, value) {
							return value.split('_')[0]+'_'+i+'_err';
						});

						i++;
					});
				}
			}
		});
	});


	$('#no-kk').keypress(function (e) {
		if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	$('#nik-art').keypress(function (e) {
		if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	$('#nourut-keluarga').keypress(function (e) {
		if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	$('#jum-art').keypress(function (e) {
		if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	$('#nik-t-iv').keypress(function (e) {
		if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	$('#jum-kel').keypress(function (e) {
		if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	$('#spkt55').keypress(function (e) {
		if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	$('#umur-art').keypress(function (e) {
		if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	$(document).on('change', 'input[name=umur-art]', function(){
		var idx = $(this).attr('id').split('_')[1];
		if(idx == undefined){
			if(parseInt($(this).val()) > 5){
				$('#spkt59').parent('div').removeClass('uk-disabled');
				$('#spkt60').parent('div').removeClass('uk-disabled');
				$('#spkt61').parent('div').removeClass('uk-disabled');
				$('#spkt62').parent('div').removeClass('uk-disabled');
				$('#spkt63').parent('div').removeClass('uk-disabled');
				$('#spkt63-1').removeAttr('disabled');
				$('#spkt64').parent('div').removeClass('uk-disabled');
				$('#spkt65').parent('div').removeClass('uk-disabled');
			}else{
				$('#spkt59').val('').change();
				$('#spkt60').val('').change();
				$('#spkt61').val('').change();
				$('#spkt62').val('').change();
				$('#spkt63').val('').change();
				$('#spkt63-1').val('');
				$('#spkt64').val('').change();
				$('#spkt65').val('').change();

				$('#spkt59').parent('div').addClass('uk-disabled');
				$('#spkt60').parent('div').addClass('uk-disabled');
				$('#spkt61').parent('div').addClass('uk-disabled');
				$('#spkt62').parent('div').addClass('uk-disabled');
				$('#spkt63').parent('div').addClass('uk-disabled');
				$('#spkt63-1').attr('disabled', 'disabled');
				$('#spkt64').parent('div').addClass('uk-disabled');
				$('#spkt65').parent('div').addClass('uk-disabled');
			}
			if($('#spkt52').val() === '2' && (parseInt($(this).val()) >= 10 && parseInt($(this).val()) <= 49) && $('#jenkel-art').val() == '2'){
				$('#spkt56').parent('div').removeClass('uk-disabled');
			}else{
				$('#spkt56').val('').change();
				$('#spkt56').parent('div').addClass('uk-disabled');
			}

		}else{
			if(parseInt($(this).val()) > 5){
				$('#spkt59_'+idx).parent('div').removeClass('uk-disabled');
				$('#spkt60_'+idx).parent('div').removeClass('uk-disabled');
				$('#spkt61_'+idx).parent('div').removeClass('uk-disabled');
				$('#spkt62_'+idx).parent('div').removeClass('uk-disabled');
				$('#spkt63_'+idx).parent('div').removeClass('uk-disabled');
				$('#spkt63-1_'+idx).parent('div').removeClass('uk-disabled');
				$('#spkt64_'+idx).parent('div').removeClass('uk-disabled');
				$('#spkt65_'+idx).parent('div').removeClass('uk-disabled');

			}else{
				$('#spkt59_'+idx).val('').change();
				$('#spkt60_'+idx).val('').change();
				$('#spkt61_'+idx).val('').change();
				$('#spkt62_'+idx).val('').change();
				$('#spkt63_'+idx).val('').change();
				$('#spkt63-1_'+idx).val('');
				$('#spkt64_'+idx).val('').change();
				$('#spkt65_'+idx).val('').change();

				$('#spkt59_'+idx).parent('div').addClass('uk-disabled');
				$('#spkt60_'+idx).parent('div').addClass('uk-disabled');
				$('#spkt61_'+idx).parent('div').addClass('uk-disabled');
				$('#spkt62_'+idx).parent('div').addClass('uk-disabled');
				$('#spkt63_'+idx).parent('div').addClass('uk-disabled');
				$('#spkt63-1_'+idx).parent('div').addClass('uk-disabled');
				$('#spkt64_'+idx).parent('div').addClass('uk-disabled');
				$('#spkt65_'+idx).parent('div').addClass('uk-disabled');
			}

			if($('#spkt52_'+idx).val() === '2' && (parseInt($(this).val()) >= 10 && parseInt($(this).val()) <= 49) && $('#jenkel-art_'+idx).val() == '2'){
				$('#spkt56_'+idx).parent('div').removeClass('uk-disabled');
			}else{
				$('#spkt56_'+idx).val('').change();
				$('#spkt56_'+idx).parent('div').addClass('uk-disabled');
			}

		}
	});

	$(document).on('change', 'select[name=spkt52]', function(){
		var idx = $(this).attr('id').split('_')[1];
		if(idx == undefined){
			if($(this).val() === '2' || $(this).val() === '3'){
				$('#spkt53').parent('div').removeClass('uk-disabled');
				if($(this).val() === '2' && (parseInt($('#umur-art').val()) >= 10 && parseInt($('#umur-art').val()) <= 49) && $('#jenkel-art').val() == '2'){
					$('#spkt56').parent('div').removeClass('uk-disabled');
				}else{
					$('#spkt56').val('').change();
					$('#spkt56').parent('div').addClass('uk-disabled');
				}
			}else{
				$('#spkt53').val('').change();
				$('#spkt53').parent('div').addClass('uk-disabled');
			}
		}else{
			if($(this).val() === '2' || $(this).val() === '3'){
				$('#spkt53_'+idx).parent('div').removeClass('uk-disabled');
				if($(this).val() === '2' && (parseInt($('#umur-art_'+idx).val()) >= 10 && parseInt($('#umur-art_'+idx).val()) <= 49) && $('#jenkel-art_'+idx).val() == '2'){
					$('#spkt56_'+idx).parent('div').removeClass('uk-disabled');
				}else{
					$('#spkt56_'+idx).val('').change();
					$('#spkt56_'+idx).parent('div').addClass('uk-disabled');
				}
			}else{
				$('#spkt53_'+idx).val('').change();
				$('#spkt53_'+idx).parent('div').addClass('uk-disabled');
			}
		}
	});

	$(document).on('change', 'select[name=jenkel-art]', function(){
		var idx = $(this).attr('id').split('_')[1];
		if(idx == undefined){
			if($(this).val() === '2' && (parseInt($('#umur-art').val()) >= 10 && parseInt($('#umur-art').val()) <= 49) && $('#spkt52').val() == '2'){
				$('#spkt56').parent('div').removeClass('uk-disabled');
			}else{
				$('#spkt56').val('').change();
				$('#spkt56').parent('div').addClass('uk-disabled');
			}
		}else{
			if($(this).val() === '2' && (parseInt($('#umur-art_'+idx).val()) >= 10 && parseInt($('#umur-art_'+idx).val()) <= 49) && $('#spkt52_'+idx).val() == '2'){
				$('#spkt56_'+idx).parent('div').removeClass('uk-disabled');
			}else{
				$('#spkt56_'+idx).val('').change();
				$('#spkt56_'+idx).parent('div').addClass('uk-disabled');
			}
		}
	});

	$(document).on('change', 'select[name=spkt63]', function(){
		var idx = $(this).attr('id').split('_')[1];
		if(idx == undefined){
			if($(this).val() === '2'){
				$('#spkt63-1').val('');
				$('#spkt63-1').attr('disabled', 'disabled');
			}else{
				$('#spkt63-1').removeAttr('disabled');
			}
		}else{
			if($(this).val() === '2'){
				$('#spkt63-1_'+idx).val('');
				$('#spkt63-1_'+idx).attr('disabled', 'disabled');
			}else{
				$('#spkt63-1_'+idx).removeAttr('disabled');
			}
		}
	});

	$(document).on('change', 'input[name=spkt55]', function(){
		var idx = $(this).attr('id').split('_')[1];
		if(idx == undefined){
			$('input[name=spkt55-1]:eq(0)').removeAttr('checked');
			$('input[name=spkt55-1]:eq(1)').removeAttr('checked');
			$('input[name=spkt55-1]:eq(2)').removeAttr('checked');
			$('input[name=spkt55-1]:eq(3)').removeAttr('checked');
			$('input[name=spkt55-1]:eq(4)').removeAttr('checked');
			if($(this).val() === '0'){

				$('input[name=spkt55-1]:eq(0)').prop('checked',true);
			}
			if($(this).val() === '1' || $(this).val() === '3' || $(this).val() === '5' || $(this).val() === '7' || $(this).val() === '9'
			|| $(this).val() === '11' || $(this).val() === '13' || $(this).val() === '15'){

				$('input[name=spkt55-1]:eq(1)').prop('checked',true);
			}
			if($(this).val() === '2' || $(this).val() === '3' || $(this).val() === '6' || $(this).val() === '7' || $(this).val() === '10'
			|| $(this).val() === '11' || $(this).val() === '14' || $(this).val() === '15'){

				$('input[name=spkt55-1]:eq(2)').prop('checked',true);

			}
			if($(this).val() === '4' || $(this).val() === '5' || $(this).val() === '6' || $(this).val() === '7' || $(this).val() === '12'
			|| $(this).val() === '13' || $(this).val() === '14' || $(this).val() === '15'){

				$('input[name=spkt55-1]:eq(3)').prop('checked',true);
			}
			if($(this).val() === '8' || $(this).val() === '9' || $(this).val() === '10' || $(this).val() === '11' || $(this).val() === '12'
			|| $(this).val() === '13' || $(this).val() === '14' || $(this).val() === '15'){

				$('input[name=spkt55-1]:eq(4)').prop('checked',true);
			}

		}else{
			$('input[name=spkt55-1_'+idx+']:eq(0)').removeAttr('checked');
			$('input[name=spkt55-1_'+idx+']:eq(1)').removeAttr('checked');
			$('input[name=spkt55-1_'+idx+']:eq(2)').removeAttr('checked');
			$('input[name=spkt55-1_'+idx+']:eq(3)').removeAttr('checked');
			$('input[name=spkt55-1_'+idx+']:eq(4)').removeAttr('checked');
			if($(this).val() === '0'){
				$('input[name=spkt55-1_'+idx+']:eq(0)').prop('checked',true);
			}
			if($(this).val() === '1' || $(this).val() === '3' || $(this).val() === '5' || $(this).val() === '7' || $(this).val() === '9'
			|| $(this).val() === '11' || $(this).val() === '13' || $(this).val() === '15'){
				$('input[name=spkt55-1_'+idx+']:eq(1)').prop('checked',true);
			}
			if($(this).val() === '2' || $(this).val() === '3' || $(this).val() === '6' || $(this).val() === '7' || $(this).val() === '10'
			|| $(this).val() === '11' || $(this).val() === '14' || $(this).val() === '15'){
				$('input[name=spkt55-1_'+idx+']:eq(2)').prop('checked',true);

			}
			if($(this).val() === '4' || $(this).val() === '5' || $(this).val() === '6' || $(this).val() === '7' || $(this).val() === '12'
			|| $(this).val() === '13' || $(this).val() === '14' || $(this).val() === '15'){
				$('input[name=spkt55-1_'+idx+']:eq(3)').prop('checked',true);
			}
			if($(this).val() === '8' || $(this).val() === '9' || $(this).val() === '10' || $(this).val() === '11' || $(this).val() === '12'
			|| $(this).val() === '13' || $(this).val() === '14' || $(this).val() === '15'){
				$('input[name=spkt55-1_'+idx+']:eq(4)').prop('checked',true);
			}
		}
	});


	$('#form-perubahan-ppfm').submit(function(e){
		e.preventDefault();
		var asset_var = {},
			rt_var = {},
			arr_rt = [],
			arr_asset = [],
			status_rt = 1,
			status_asset = 1,
			formData = new FormData();

		var values = $('input[data-status^=rt]').map(function() {
			arr_rt.push(this.name);
		}).get();

		var values = $('select[data-status^=rt]').map(function() {
			arr_rt.push(this.name);
		}).get();

		$.each(arr_rt.unique(), function(i, el){
			if($('input[name='+el+']').attr('type') == 'checked'){
				if($('input[name='+el+']:checked').val() !== undefined){
					rt_var['datart.0.'+el] = $('input[name='+el+']:checked').val();
				}
			}else if($('input[name='+el+']').attr('type') == 'text'){
				rt_var['datart.0.'+el] = $('input[name='+el+']').val();
			}else{
				rt_var['datart.0.'+el] = $('select[name='+el+']').val();
			}
		});

		var values = $('input[data-status^=asset]').map(function() {
			arr_asset.push(this.name);
		}).get();

		var values = $('select[data-status^=asset]').map(function() {
			arr_asset.push(this.name);
		}).get();

		$.each(arr_asset.unique(), function(i, el){
			if($('input[name='+el+']').attr('type') == 'checked'){
				if($('input[name='+el+']:checked').val() !== undefined){
					asset_var['asset.0.'+el] = $('input[name='+el+']:checked').val();
				}
			}else if($('input[name='+el+']').attr('type') == 'text'){
				asset_var['asset.0.'+el] = $('input[name='+el+']').val();
			}else{
				asset_var['asset.0.'+el] = $('select[name='+el+']').val();
			}
		});

		if($('#sls').val() === '' || $('#no-kk').val() === '' || $('#no-kk').val().length < 16
			|| $('#jum-kel').val() === ''
		){

			if($('#no-kk').val() === ''){
				$('#no-kk').addClass('error');
				$('#no-kk_err').html('Nomor Kartu Keluarga wajib di isi');
			}else if($('#no-kk').val().length < 16){
				$('#no-kk').addClass('error');
				$('#no-kk_err').html('Nomor Kartu Keluarga kurang dari 16 digit');
			}else{
				$('#no-kk').removeClass('error');
				$('#no-kk_err').html('');
			}

			if($('#sls').val() === ''){
				$('#sls').addClass('error');
				$('#sls_err').html('Nomor Induk Kependudukan wajib di isi');
			}else if($('#sls').val().length < 16){
				$('#sls').addClass('error');
				$('#sls_err').html('Nomor Induk Kependudukan kurang dari 16 digit');
			}else{
				$('#sls').removeClass('error');
				$('#sls_err').html('');
			}

			if($('#jum-kel').val() === ''){
				$('#jum-kel').addClass('error');
				$('#jum-kel_err').html('Nama Lengkap wajib di isi');
			}else{
				$('#jum-kel').removeClass('error');
				$('#jum-kel_err').html('');
			}

		}else{

			formData.append('sls', $('#sls').val());
			formData.append('nokk', $('#no-kk').val());
			formData.append('jum_kel', $('#jum-kel').val());
			formData.append('rtVar', JSON.stringify(rt_var));
			formData.append('assetVar', JSON.stringify(asset_var));
			formData.append('id', $('#submit-perubahan').attr('data-id'));
			formData.append('_token', $('#_token').val());

			$.ajax({
				url: '/ppfm/peserta-lama',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data) {
					msg = $.parseJSON(data);
					if(msg.success == 1){
						$('#alert-add-ppfm').removeClass('uk-alert-warning');
						$('#alert-add-ppfm').removeClass('uk-hidden');
						$('#alert-add-ppfm').addClass('uk-alert-success');
						$('#alert-add-ppfm').find('p').html(msg.message);
						setTimeout(function(){
							location.reload(true);
						}, 2000);
					}else{
						$('#alert-add-ppfm').removeClass('uk-alert-success');
						$('#alert-add-ppfm').removeClass('uk-hidden');
						$('#alert-add-ppfm').addClass('uk-alert-warning');
						$('#alert-add-ppfm').find('p').html(msg.message);
					}
				},
				error: function(response){
					$('#alert-add-ppfm').removeClass('uk-alert-success');
					$('#alert-add-ppfm').removeClass('uk-hidden');
					$('#alert-add-ppfm').addClass('uk-alert-warning');
					$('#alert-add-ppfm').find('p').html('Terjadi kesalahan. Silahkan ulangi beberapa saat lagi');

				}
			});
		}

	});


	$(document).on('click', '#btn-save', function(){
		var formData = new FormData(), index = $(this).attr('data-id'),
			indi_var = {},
			arr_indi = [],
			status_indi = 1;

		var values = $('input[data-status^=individu_'+$(this).attr('data-id')+']').map(function() {
			arr_indi.push(this.name);
		}).get();

		var values = $('select[data-status^=individu_'+$(this).attr('data-id')+']').map(function() {
			arr_indi.push(this.name);
		}).get();

		$.each(arr_indi.unique(), function(i, el){
			if($('input[name='+el+']').attr('type') == 'checked'){
				if($('input[name='+el+']:checked').val() !== undefined){
					indi_var['individu.'+index+'.'+el] = $('input[id='+el+'_'+index+']:checked').val();
				}
			}else if($('input[name='+el+']').attr('type') == 'text'){
				indi_var['individu.'+index+'.'+el] = $('input[id='+el+'_'+index+']').val();
			}else{
				indi_var['individu.'+index+'.'+el] = $('select[id='+el+'_'+index+']').val();
			}
		});

		if($('#nik_'+$(this).attr('data-id')).val() == '' || $('#nik_'+$(this).attr('data-id')).val().length < 16
		|| $('#nama_'+$(this).attr('data-id')).val() == ''
		){
			$('html, body').animate({scrollTop : 500},500);
			if($('#nik_'+$(this).attr('data-id')).val() === ''){
				$('#nik_'+$(this).attr('data-id')).addClass('error');
				$('#nik_'+$(this).attr('data-id')+'_err').html('Nomor Induk Kependudukan wajib di isi');
			}else if($('#nik_'+$(this).attr('data-id')).val().length < 16){
				$('#nik_'+$(this).attr('data-id')).addClass('error');
				$('#nik_'+$(this).attr('data-id')+'_err').html('Nomor Induk Kependudukan kurang dari 16 digit');
			}else{
				$('#nik_'+$(this).attr('data-id')).removeClass('error');
				$('#nik_'+$(this).attr('data-id')+'_err').html('');
			}
			if($('#nama_'+$(this).attr('data-id')).val() === ''){
				$('#nama_'+$(this).attr('data-id')).addClass('error');
				$('#nama_'+$(this).attr('data-id')+'_err').html('Nama anggota rumah tangga wajib di isi');
			}else{
				$('#nama_'+$(this).attr('data-id')).removeClass('error');
				$('#nama_'+$(this).attr('data-id')+'_err').html('');
			}
			
		}else{
			formData.append('kodepeserta', $(this).attr('data-kdp'));
			formData.append('index', $(this).attr('data-id'));
			formData.append('nik', $('#nik_'+$(this).attr('data-id')).val());
			formData.append('nama', $('#nama_'+$(this).attr('data-id')).val());
			formData.append('indiVar', JSON.stringify(indi_var));
			formData.append('_token', $('#_token').val());

			$.ajax({
				url: '/ppfm/update/individu',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data) {
					msg = $.parseJSON(data);
					if(msg.success == 1){
						$('#alert-add-art_'+index).removeClass('uk-alert-warning');
						$('#alert-add-art_'+index).removeClass('uk-hidden');
						$('#alert-add-art_'+index).addClass('uk-alert-success');
						$('#alert-add-art_'+index).find('p').html(msg.message);
						setTimeout(function(){
							$('#alert-add-art_'+index).removeClass('uk-alert-warning');
							$('#alert-add-art_'+index).addClass('uk-hidden');
							$('#alert-add-art_'+index).removeClass('uk-alert-success');
							$('#alert-add-art_'+index).find('p').html('');
							$('#fs-page-iv > li > ol > li').each(function(key, value) {
								var n = $('[id="nama_'+ key +'"]').val() + ' ( ' +  $('[id="nik_'+ key +'"]').val() + ')';
								$(value).children('a').text(n);
							});
						}, 1500);

					}else{
						$('#alert-add-art_'+index).removeClass('uk-alert-success');
						$('#alert-add-art_'+index).removeClass('uk-hidden');
						$('#alert-add-art_'+index).addClass('uk-alert-warning');
						$('#alert-add-art_'+index).find('p').html(msg.message);

						setTimeout(function(){
							$('#alert-add-art_'+index).removeClass('uk-alert-warning');
							$('#alert-add-art_'+index).addClass('uk-hidden');
							$('#alert-add-art_'+index).removeClass('uk-alert-success');
							$('#alert-add-art_'+index).find('p').html('');
						}, 2000);
					}
				},
				error: function(response){
					$('#alert-add-art_'+index).removeClass('uk-alert-success');
					$('#alert-add-art_'+index).removeClass('uk-hidden');
					$('#alert-add-art_'+index).addClass('uk-alert-warning');
					$('#alert-add-art_'+index).find('p').html('Terjadi kesalahan. Silahkan ulangi beberapa saat lagi');

				}
			});

		}
	});


	$(document).on('click', '#btn-save-tanggungan', function(){
		var bk_nikah, st_hamil, formData = new FormData(), index = $(this).attr('data-id');

		if($('#nik-t-iv_'+index).val() == '' || $('#nik-t-iv_'+index).val().length < 16
		|| $('#nama-t-iv_'+index).val() == '' || $('#alamat-t-iv_'+index).val() == ''
		|| $('#nama-sekolah-t-iv_'+index).val() == '' || $('#nisn-t-iv_'+index).val() == ''
		){
			$('html, body').animate({scrollTop : 500},500);
			if($('#nik-t-iv_'+index).val() === ''){
				$('#nik-t-iv_'+index).addClass('error');
				$('#nik-t-iv_'+index+'_err').html('Nomor Induk Kependudukan wajib di isi');
			}else if($('#nik-t-iv_'+index).val().length < 16){
				$('#nik-t-iv_'+index).addClass('error');
				$('#nik-t-iv_'+index+'_err').html('Nomor Induk Kependudukan kurang dari 16 digit');
			}else{
				$('#nik-t-iv_'+index).removeClass('error');
				$('#nik-t-iv_'+index+'_err').html('');
			}
			if($('#nama-t-iv_'+index).val() === ''){
				$('#nama-t-iv_'+index).addClass('error');
				$('#nama-t-iv_'+index+'_err').html('Nama wajib di isi');
			}else{
				$('#nama-t-iv_'+index).removeClass('error');
				$('#nama-t-iv_'+index+'_err').html('');
			}
			if($('#alamat-t-iv_'+index).val() === ''){
				$('#alamat-t-iv_'+index).addClass('error');
				$('#alamat-t-iv_'+index+'_err').html('Alamat wajib di isi');
			}else{
				$('#alamat-t-iv_'+index).removeClass('error');
				$('#alamat-t-iv_'+index+'_err').html('');
			}
			if($('#nama-sekolah-t-iv_'+index).val() === ''){
				$('#nama-sekolah-t-iv_'+index).addClass('error');
				$('#nama-sekolah-t-iv_'+index+'_err').html('Nama sekolah wajib di isi');
			}else{
				$('#nama-sekolah-t-iv_'+index).removeClass('error');
				$('#nama-sekolah-t-iv_'+index+'_err').html('');
			}
			if($('#nisn-t-iv_'+index).val() === ''){
				$('#nisn-t-iv_'+index).addClass('error');
				$('#nisn-t-iv_'+index+'_err').html('Nisn wajib di isi');
			}else{
				$('#nisn-t-iv_'+index).removeClass('error');
				$('#nisn-t-iv_'+index+'_err').html('');
			}
		}else{
			formData.append('kodepeserta', $(this).attr('data-kdp'));
			formData.append('nik', $('#nik-t-iv_'+index).val());
			formData.append('nama', $('#nama-t-iv_'+index).val());
			formData.append('alamat', $('#alamat-t-iv_'+index).val());
			formData.append('namasekolah', $('#nama-sekolah-t-iv_'+index).val());
			formData.append('nisn', $('#nisn-t-iv_'+index).val());
			formData.append('_token', $('#_token').val());

			$.ajax({
				url: '/ppfm/update/individu/tanggungan',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data) {
					msg = $.parseJSON(data);
					if(msg.success == 1){
						$('#alert-add-tanggungan_'+index).removeClass('uk-alert-warning');
						$('#alert-add-tanggungan_'+index).removeClass('uk-hidden');
						$('#alert-add-tanggungan_'+index).addClass('uk-alert-success');
						$('#alert-add-tanggungan_'+index).find('p').html(msg.message);
						setTimeout(function(){
							$('#alert-add-tanggungan_'+index).removeClass('uk-alert-warning');
							$('#alert-add-tanggungan_'+index).addClass('uk-hidden');
							$('#alert-add-tanggungan_'+index).removeClass('uk-alert-success');
							$('#alert-add-tanggungan_'+index).find('p').html('');
							$('#fs-page-iv-2 > li > ol > li').each(function(key, value) {
								var n = $('[id="nama-t-iv_'+ key +'"]').val() + ' ( ' +  $('[id="nik-t-iv_'+ key +'"]').val() + ')';
								$(value).children('a').text(n);
							});
						}, 1500);

					}else{
						$('#alert-add-tanggungan_'+index).removeClass('uk-alert-success');
						$('#alert-add-tanggungan_'+index).removeClass('uk-hidden');
						$('#alert-add-tanggungan_'+index).addClass('uk-alert-warning');
						$('#alert-add-tanggungan_'+index).find('p').html(msg.message);

						setTimeout(function(){
							$('#alert-add-tanggungan_'+index).removeClass('uk-alert-warning');
							$('#alert-add-tanggungan_'+index).addClass('uk-hidden');
							$('#alert-add-tanggungan_'+index).removeClass('uk-alert-success');
							$('#alert-add-tanggungan_'+index).find('p').html('');
						}, 2000);
					}
				},
				error: function(response){
					$('#alert-add-tanggungan_'+index).removeClass('uk-alert-success');
					$('#alert-add-tanggungan_'+index).removeClass('uk-hidden');
					$('#alert-add-tanggungan_'+index).addClass('uk-alert-warning');
					$('#alert-add-tanggungan_'+index).find('p').html('Terjadi kesalahan. Silahkan ulangi beberapa saat lagi');

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
            url: '/ppfm/peserta-lama/delete/'+ $(this).attr('data-id'),
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

	$('#cetak-peserta-lama').printPage();

	$('#search-kec').on('change', function(){
		location.href = '/ppfm/peserta-lama?kec='+$(this).val();
	});
});
