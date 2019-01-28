$(document).ready(function(){
	if(sidebar == 'sidebar-finduk-individu'){
		$('.m-sidebar').find('.uk-active').removeClass('uk-active');
		$('#sidebar-findukbdt').addClass('uk-active');
		$('#sidebar-finduk-individu').addClass('uk-active');
	}else if(sidebar == 'sidebar-finduk-rt'){
		$('.m-sidebar').find('.uk-active').removeClass('uk-active');
		$('#sidebar-findukbdt').addClass('uk-active');
		$('#sidebar-finduk-rt').addClass('uk-active');
	}

	$('#search-kec').on('change', function(){
		location.href = '/induk/individu?kec='+$(this).val();
	});

	$('#search-kec-rt').on('change', function(){
		location.href = '/induk/rumahtangga?kec='+$(this).val();
	});

	$('#search-by').on('change', function(){
		var urlParams = new URLSearchParams(window.location.search),
			by = $('#search-by').val(),
			q = $('#q').val();

		location.href = '?kelurahan='+urlParams.get('kelurahan')+'&indikator='+urlParams.get('indikator')+'&kategori='+urlParams.get('kategori')+'&value='+urlParams.get('value')+'&by='+by+'&q='+q;

	})

	$('#q').on('keypress', function(e){
		if(e.which == 13){
			var urlParams = new URLSearchParams(window.location.search),
			by = $('#search-by').val(),
			q = $('#q').val();

			location.href = '?kelurahan='+urlParams.get('kelurahan')+'&indikator='+urlParams.get('indikator')+'&kategori='+urlParams.get('kategori')+'&value='+urlParams.get('value')+'&by='+by+'&q='+q;		
		}
	})

	$('#search-by-ang').on('change', function(){
		var urlParams = new URLSearchParams(window.location.search),
			by = $('#search-by-ang').val(),
			q = $('#q-ang').val();

		location.href = '?by='+by+'&q='+q;

	})

	$('#q-ang').on('keypress', function(e){
		if(e.which == 13){
			var urlParams = new URLSearchParams(window.location.search),
			by = $('#search-by-ang').val(),
			q = $('#q-ang').val();

			location.href = '?by='+by+'&q='+q;		
		}
	})
});