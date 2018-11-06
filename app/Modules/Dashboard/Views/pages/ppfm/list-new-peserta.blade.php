@extends('Dashboard::layouts.main')

@section('content')
<div id="pendaftaran-mpm-content" class="m-content">
	<div class="mc-header">
		<style>
			#pendaftaran-mpm-content > .mc-header {
				background: url('/assets/img/pmpm.jpg') no-repeat center center;
				background-size: cover;
			}
		</style>
		<div class="mch-text">
			<h2>Daftar Peserta Data Terpadu PPFM</h2>
		</div>
	</div>
	<div class="mc-breadcrumb" data-uk-sticky="{top:60}">
		<ul class="uk-breadcrumb">
			<li><a href="{{ URL('/dashboard') }}">Dashboard</a></li>
			<li><a href="javascript:;">Daftar Peserta Data Terpadu PPFM</a></li>
		</ul>
	</div>
	<div class="mc-form">
		<div class="mc-form-wrapper">
			<div class="mc-form-inner">
				<div>
					<div class="mcf-content">
						<div class="mcf-title">
							<h3>Daftar Peserta Data Terpadu PPFM</h3>
						</div>
						<div class="main-table">
							<div class="mt-wrapper">
								<div class="mt-inner">
									<div class="mt-aksi">
										<!-- <div class="uk-clearfix">
											<div class="uk-float-right">
												 <div class="uk-float-left">
													<div class="uk-button uk-form-select" data-uk-form-select>
														<span class="">Pilih...</span>
														<i class="uk-icon-angle-down uk-icon-medium"></i>
														<select id="search-kec" name="search-kec">
															<option value="" {{ empty($_GET['kec']) ? 'selected' : '' }}>Semua Kecamatan</option>
															@foreach($kecamatan as $listkec)
															<option value="{{ $listkec->id_kecamatan }}" {{ ($listkec->id_kecamatan == (empty($_GET['kec']) ? '' : $_GET['kec']) ? 'selected' : '') }} >{{ ucwords(strtolower($listkec->kecamatan)) }}</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="uk-float-right">
													<a id="cetak-peserta-baru" href="{{ URL('/ppfm/cetak-peserta-baru').'?kec='.((empty($_GET['kec'])) ? '' : $_GET['kec']).'&page='.((empty($_GET['page'])) ? '' : $_GET['page']) }}"><button  class="button-primary cetak">Cetak</button></a>
												</div>
											</div>
										   
										</div> -->
										<div class="uk-clearfix">
											<div class="uk-float-right">
												<ul>
													<li>
														<div class="uk-button uk-form-select" data-uk-form-select>
															<span class="">Pilih...</span>
															<i class="uk-icon-angle-down uk-icon-medium"></i>
															<select id="search-kec" name="search-kec">
																<option value="" {{ empty($_GET['kec']) ? 'selected' : '' }}>Semua Kecamatan</option>
																@foreach($kecamatan as $listkec)
																<option value="{{ $listkec->id_kecamatan }}" {{ ($listkec->id_kecamatan == (empty($_GET['kec']) ? '' : $_GET['kec']) ? 'selected' : '') }} >{{ ucwords(strtolower($listkec->kecamatan)) }}</option>
																@endforeach
															</select>
														</div>
													</li>
													<li><a id="cetak-peserta-baru" href="{{ URL('/ppfm/cetak-peserta-baru').'?kec='.((empty($_GET['kec'])) ? '' : $_GET['kec']).'&page='.((empty($_GET['page'])) ? '' : $_GET['page']) }}"><button  class="button-primary cetak">Cetak</button></a></li>
												</ul>
											</div>
										</div>
									</div>
									<div>
										Jumlah Peserta <b>{{$jumpeserta}}</b> Keluarga
										<br>
										<table class="uk-table uk-table-hover">
											<thead>
												<tr>
													<th>No.</th>
													<th>No. KK</th>
													<th>Nama Jalan RT/RW</th>
													<th>Kelurahan</th>
													<th>Kecamatan</th>
													<th>NIK Kepala RuTa</th>
													<th>Nama Kepala RuTa</th>
													<th>Verifikasi</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												@php($i = empty($_GET['page']) ? 1 : ((($_GET['page'] - 1) * 10) + 1))
												@foreach($peserta as $listpeserta)
												{{--@if(App\Models\PesertaMpm::getskrining($listpeserta->kodepeserta) == false)--}}
												<tr>
													<td>{{ $i++ }}</td>
													<td>{{ $listpeserta->nokk }}</td>
													<td width="10%">{{ $listpeserta->b1_k6 }}</td>
													<td>{{ ucwords(strtolower(App\Models\Kelurahan::getkelurahan($listpeserta->des))) }}</td>
                                                    <td>{{ ucwords(strtolower(App\Models\Kecamatan::getkecamatan($listpeserta->kec))) }}</td>
                                                    <td>{{ (!empty(App\Models\PesertaMpm::getkrt($listpeserta->kodepeserta)) ? App\Models\PesertaMpm::getkrt($listpeserta->kodepeserta)[0]['nik'] : '') }}</td>
                                                    <td>{{ (!empty(App\Models\PesertaMpm::getkrt($listpeserta->kodepeserta)) ? App\Models\PesertaMpm::getkrt($listpeserta->kodepeserta)[0]['nama'] : '') }}</td>
													<td>{!! ($listpeserta->verifikasi == 1) ? '<i class="icon-button check uk-icon-small uk-icon-check-circle-o"></i>' : '<i class="icon-button times uk-icon-small uk-icon-times-circle-o"></i>' !!}</td>
													<td>
	                                                    @if(App\Models\PesertaMpm::getskrining($listpeserta->kodepeserta) == true)
															<i class="icon-button times uk-icon-small uk-icon-times-circle-o"></i>
														@else
															<div class="uk-button-group">
																<button class="uk-button" type="button">Aksi</button>
																<div data-uk-dropdown="{mode:'click', pos:'bottom-right'}">
																	<button class="uk-button" type="button"><i class="uk-icon-caret-down"></i></button>
																	<div class="uk-dropdown uk-dropdown-small">
																		<ul>
																			<li><a href="{{ URL('/ppfm/verifikasi/').'/'.$listpeserta->_id }}">Verifikasi</a></li>
																			<li><a href="javascript:;" data-id="{{ $listpeserta->_id }}" id="del-peserta">Hapus</a></li>
																		</ul>
																	</div>
																</div>
															</div>
														@endif
													</td>
												</tr>
												{{--@endif--}}
												@endforeach
											</tbody>
										</table>
									</div>

									@if($peserta->lastPage() > 1)
									<div class="pagination uk-clearfix">
										<div class="uk-float-right">
											<ul class="uk-pagination">
												<li class="{{ ((empty($_GET['page'])) || ($_GET['page'] == 1)) ? 'uk-disabled' : '' }}"><a href="{{ URL('/ppfm/peserta-baru').'?kec='.((empty($_GET['kec'])) ? '' : $_GET['kec']).'&page='.(!empty($_GET['page']) ? ($_GET['page'] - 1) : '1') }}"><i class="uk-icon-caret-left"></i></a></li>
												@php($pageNow = empty($_GET['page']) ? 1 : $_GET['page'])
												@if($peserta->lastPage() > 12)
													@if(($peserta->lastPage() - $pageNow) > 12)
														@for($i = $pageNow;$i <= $pageNow + 7; $i++)
															<li class="{{ ($pageNow == $i) ? 'uk-active' : '' }}"><a href="{{ URL('/ppfm/peserta-baru').'?kec='.((empty($_GET['kec'])) ? '' : $_GET['kec']).'&page='.$i }}">{{ $i }}</a></li>
														@endfor
														<li class="uk-disabled"><span>...</span></li>
														@for($i = ($peserta->lastPage() - 1);$i <= $peserta->lastPage(); $i++)
															<li class="{{ ($pageNow == $i) ? 'uk-active' : '' }}"><a href="{{ URL('/ppfm/peserta-baru').'?kec='.((empty($_GET['kec'])) ? '' : $_GET['kec']).'&page='.$i }}">{{ $i }}</a></li>
														@endfor
													@else
														@for($i = 1;$i <= 7; $i++)
															<li class="{{ ($pageNow == $i) ? 'uk-active' : '' }}"><a href="{{ URL('/ppfm/peserta-baru').'?kec='.((empty($_GET['kec'])) ? '' : $_GET['kec']).'&page='.$i }}">{{ $i }}</a></li>
														@endfor
														<li class="uk-disabled"><span>...</span></li>
														@for($i = $pageNow;$i <= $pageNow + ($peserta->lastPage() - $pageNow); $i++)
															<li class="{{ ($pageNow == $i) ? 'uk-active' : '' }}"><a href="{{ URL('/ppfm/peserta-baru').'?kec='.((empty($_GET['kec'])) ? '' : $_GET['kec']).'&page='.$i }}">{{ $i }}</a></li>
														@endfor
													@endif
												@else
													@for($i = 1;$i <= $peserta->lastPage(); $i++)
														<li class="{{ ($pageNow == $i) ? 'uk-active' : '' }}"><a href="{{ URL('/ppfm/peserta-baru').'?kec='.((empty($_GET['kec'])) ? '' : $_GET['kec']).'&page='.$i }}">{{ $i }}</a></li>
													@endfor
												@endif
												<li class="{{ ((!empty($_GET['page'])) && ($_GET['page'] == $peserta->lastPage())) ? 'disabled' : '' }}"><a href="{{ URL('/ppfm/peserta-baru').'?kec='.((empty($_GET['kec'])) ? '' : $_GET['kec']).'&page='.(!empty($_GET['page']) ? ($_GET['page'] + 1) : '2') }}"><i class="uk-icon-caret-right"></i></a></li>
											</ul>
										</div>
									</div>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<div id="modal-del" class="uk-modal">
	<div class="uk-modal-dialog">
		<div class="uk-modal-header">
			<div class="uk-clearfix">
				<div class="uk-float-left">
					<h3>Peringatan!</h3>
				</div>
				<div class="uk-float-right">
					<button class="uk-modal-close uk-close"></button>
				</div>
			</div>
		</div>
		<div class="modal-content">
			<p>Apakah anda yakin ingin menghapus data ini?</p>
			<div id="alert-modal" class="uk-alert uk-alert-large uk-hidden" data-uk-alert>
				<p></p>
			</div>
		</div>
		<div class="uk-modal-footer">
			<ul>
				<li><button class="button-blue uk-modal-close" >Tidak</button></li>
				<li><button class="button-red" data-id="" id="delPeserta">Ya</button></li>
			</ul>
		</div>
	</div>
</div>

<script>
	var sidebar = 'sidebar-fppfm-belum';
</script>

<script type="text/javascript" src="{{ url('/assets/js/jquery.printPage.js') }}"></script>
<script src="{{ URL('/assets/js/backend/new-ppfm.js') }}"></script>
@stop
