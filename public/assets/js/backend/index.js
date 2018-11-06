$(document).ready(function(){
	$.ajax({
		type: 'GET',
		url: '/getsummary',
		success: function(data){
			msg = $.parseJSON(data);
			var d = $.parseJSON(msg.data);
			$('#maps > svg > g, #maps > svg > path').on('mouseover', function(e) {
			e.stopPropagation();
			var regionId = this.id.replace('region-', '');
			var id = '#maps #'+ regionId +'-pin';
			var title = $(this).attr('title');
			var listId = '#list-' + regionId;
			WebuiPopovers.show(id, {title:title,content: '<button id="'+regionId+'" class="show'+regionId+'">Detail</button>',animation:'pop', placement: 'top'});
				$(listId).addClass('is-active');
				$('body').on('click', 'button.show'+regionId, function(e) {
					$(listId).addClass('is-active');
					$('.mcpwl-right ul').html(
						d.map((item, i) => {
							var r = '';
							if (regionId == item.id) {
								item.data.map((item, i) => {
									r += '<li>'+
										'<div class="uk-grid uk-grid-collapse">'+
											'<div class="uk-width-large-4-10 uk-width-medium-1-1 uk-width-small-1-1 left">'+
												'<span>'+ item.key +'</span>'+
											'</div>'+
											'<div class="uk-width-large-6-10 uk-width-medium-1-1 uk-width-small-1-1 right">'+
												'<span>'+ item.value +'</td>'+
											'</div>'+
										'</div>'+
									'</li>';
								});
							}
							return r;	
						}));
						$('.mcpwl-right ul li').show();
						$('.mcpwl-right ul li').each(function(i) {
						$(this).delay(100 * i).animate({top: 0, opacity: 1}, 100);
					});
					$('.mcpw-list-inner > div > ul > li').each(function(key, value) {
						if ($(value).attr('id') == 'list-'+regionId) {
							$(value).show();
						} else {
							$(value).hide();
						}
					});
				});
			}).on('mouseleave', function(e) {
				$('.mcpw-list-inner > div > ul > li').removeClass('is-active');
			});
			$('.mc-peta-wrapper').on('click', function(e) {
				$('.mcpw-list-inner > div > ul > li').removeClass('is-active');
				$('.mcpwl-right ul li').hide();
				$('.mcpw-list-inner > div > ul > li').show();
			});
			$('#maps-loading').addClass('uk-hidden');
			$('#maps').removeClass('uk-hidden');
        	$('#maps-failed').addClass('uk-hidden');

		},
        error: function(response){
        	$('#maps-loading').addClass('uk-hidden');
        	$('#maps-failed').removeClass('uk-hidden');
        }
	});

});