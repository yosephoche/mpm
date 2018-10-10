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
});