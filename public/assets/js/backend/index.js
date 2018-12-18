

var d=[];
$(document).ready(function(){
	$.ajax({
		type: 'GET',
		url: '/getsummary',
		success: function(data){
			msg = $.parseJSON(data);
			d = $.parseJSON(msg.data);
			
			$('#maps-loading').addClass('uk-hidden');
			$('#maps').removeClass('uk-hidden');
			$('#maps-failed').addClass('uk-hidden');
	
		},
        error: function(response){
        	$('#maps-loading').addClass('uk-hidden');
        	$('#maps-failed').removeClass('uk-hidden');
        }, 
		async: false
	});

	$(document).on('click', '.click-detail', function(e){
		$('.uk-modal-dialog').find('p').html('Data Kosong, Silahkan Isi Data MPM dan Verifikasi');
		$.UIkit.modal('#modal-informasi-detail').show();
	});
});

function closeModal() {
	$('.mc-peta-inner .mcpw-wrapper .modal-maps').remove()
}
function handleClickItemMaps(e, key, id) {
	let result = [];
	console.log($($(e).find('span.key')).text());
	console.log(id, key);
	$.ajax({
		type: 'GET',
		url: '/detail-summary?id='+id+'&kec='+key,
		success: function(data){
			msg = $.parseJSON(data);
			result = $.parseJSON(msg.data);
			console.log(result);
			no=0;
			
			result.map((item, i) => {
				if (item.id === id) {
					item.data.map((item, i) => {
					if (item.key === key) {
						$('.mc-peta-inner .mcpw-wrapper').append(
							'<div class="modal-maps" style="position: absolute;left: 0;right: 0;top: 0;bottom: 0;background: #fff;z-index: 100;">'+
							'<button style="position: absolute;background: #23c4ff;border: 1px solid #28a1e2;right: 20px;top: 15px;" onClick="closeModal()"><span class="uk-icon-remove"></span></button>'+
							'<div style="margin-top: 13px;padding: 20px;">'+
							'<table class="uk-table">'+
							'<caption>'+item.value+'</caption>'+
							'<thead>'+
							'<tr>'+
								'<th>No.</th>'+
								'<th>Kategori Indikator</th>'+
								'<th>Rendah</th>'+
								'<th>Sedang</th>'+
								'<th>Tinggi</th>'+
							'</tr>'+
							'</thead>'+
							'<tbody class="body-detail">'+

							'</tbody>'+
							'</table>'+
							'</div>'+
							'</div>'
							)
							$.each( item.detail, function( key, value ) {
								$('.body-detail').append(
								'<tr>'+
									'<td>'+(key+1)+'</td>'+
									'<td>'+ value.kategori +'</td>'+
									'<td><a href="#" class="click-detail">'+value.rendah+'</a></td>'+
									'<td><a href="#" class="click-detail">'+value.sedang+'</a></td>'+
									'<td><a href="#" class="click-detail">'+value.tinggi+'</a></td>'+
								'</tr>'
								);
							})
						}
					})

				}
			})
			
		}
	})
}

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
					item.data.map((itemData, i) => {
						r += 	'<li onClick="handleClickItemMaps(this,\'' + itemData.key + '\',\'' + item.id + '\')">'+
								'<div class="uk-grid uk-grid-collapse">'+
									'<div class="uk-width-large-10-10 uk-width-medium-1-1 uk-width-small-1-1 text-center">'+
										'<span class="key">'+ itemData.value + ' <b>[' + itemData.jum + ']</b>' +'</span>'+
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



