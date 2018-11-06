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
			<h2>Verifikasi Data PPFM</h2>
		</div>
	</div>
	<div class="mc-breadcrumb" data-uk-sticky="{top:60}">
		<ul class="uk-breadcrumb">
			<li><a href="javascript:;">Data Terpadu PPFM</a></li>
			<li><a href="{{ URL('/ppfm/peserta-lama') }}">Sudah Terdaftar</a></li>
			<li><a href="javascript:;">Verifikasi Data PPFM</a></li>
		</ul>
	</div>
	<div class="mc-form">
		<div class="mc-form-wrapper">
			<div class="mc-form-inner">
				<form id="form-perubahan-ppfm" action="" method="post" class="uk-form pendaftaran-ppfm">
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

					<div class="mcf-content">
						<div class="mcf-title">
							<h3>Formulir Perubahan Data Terpadu Program Penanganan Fakir Miskin</h3>
						</div>
						<div class="mcf-wizard-step uk-width-1-1 uk-container-center">
							<ul>
								<li class="active">
									<a href="#page-1">1</a>
								</li>
								<li class="disabled">
									<a href="#page-2">2</a>
								</li>
								<li class="disabled">
									<a href="#page-3">3</a>
								</li>
								<!-- <li class="disabled">
									<a href="#page-4">4</a>
								</li> -->
							</ul>
						</div>
						<style>
							.main .m-content .mc-form .mc-form-wrapper .mc-form-inner .pendaftaran-ppfm .mcf-wizard-step ul li {
							    display: inline-block;
							    position: relative;
							    width: 32%;
							}
						</style>
						<fieldset id="page-1">
							<ul class="mcf-list">
								<li class="mcf-item">
									<div class="title">
										<h4>I. Pengenalan Tempat</h4>
									</div>
									<div class="data uk-grid">
										<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
											<div class="data-inner">
												<label for="alamat">1. Alamat</label>
												<input id="alamat" type="text" name="alamat" value="{{ $peserta[0]->b1_k6 }}" readonly>
												<!-- <div class="error">Pesan Error</div> -->
											</div>
										</div>
										<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
											<div class="data-inner">
												<label for="kelurahan">2. Kelurahan/Desa/Sagari</label>
												<input id="kelurahan" type="text" name="kelurahan" value="{{ App\Models\Kelurahan::getkelurahan($peserta[0]->des) }}" readonly>
												<!-- <div class="error">Pesan Error</div> -->
											</div>
										</div>
										<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
											<div class="data-inner">
												<label for="kecamatan">3. Kecamatan</label>
												<input id="kecamatan" type="text" name="kecamatan" value="{{ App\Models\Kecamatan::getkecamatan($peserta[0]->kec) }}" readonly>
												<!-- <div class="error">Pesan Error</div> -->
											</div>
										</div>
										<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
											<div class="data-inner">
												<label for="sls">4. Nama SLS</label>
												<input id="sls" type="text" name="sls" value="{{ $peserta[0]->sls }}">
												<div class="error" id="sls_err"></div>
											</div>
										</div>
										<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
											<div class="data-inner">
												<label for="nourut-bdt">5. Nomor Urut Rumah Tangga (Dari PBDT 2015. FKP Kolom (1))</label>
												<input id="nourut-bdt" type="text" name="nourut-bdt" value="{{ $peserta[0]->nourut_rt }}" readonly>
												<!-- <div class="error">Pesan Error</div> -->
											</div>
										</div>
										<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
											<div class="data-inner">
												<label for="no-kk">6. No. Kartu Keluarga</label>
												<input id="no-kk" type="text" maxlength="16" name="no-kk" value="{{ $peserta[0]->nokk }}">
												<div class="error" id="no-kk_err"></div>
											</div>
										</div>
										<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
											<div class="data-inner">
												<label for="nama-krt">7. Nama Kepala Rumah Tangga</label>
												<input id="nama-krt" type="text" name="nama-krt" readonly value="{{ ((App\Models\PesertaBDT::getkrt($peserta[0]->kodepeserta)) ? App\Models\PesertaBDT::getkrt($peserta[0]->kodepeserta)[0]['nama'] : '') }}">
												<!-- <div class="error">Pesan Error</div> -->
											</div>
										</div>
										<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
											<div class="data-inner">
												<label for="jum-art">8. Jumlah ART</label>
												<input id="jum-art" type="text" name="jum-art" value="{{ count($peserta[0]->individu) }}" readonly>
												<!-- <div class="error">Pesan Error</div> -->
											</div>
										</div>
										<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
											<div class="data-inner">
												<label for="jum-kel">9. Jumlah Keluarga</label>
												<input id="jum-kel" type="text" value="{{ $peserta[0]->b1_k10 }}" name="jum-kel">
												<div class="error" id="jum-kel_err"></div>
											</div>
										</div>
										<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
											<div class="data-inner">
												<label for="statuskesejahteraan">10. Status Kesejahteraan(Desil)</label>
												<input id="statuskesejahteraan" type="text" value="{{ $peserta[0]->statuskesejahteraan }}" name="statuskesejahteraan">
												<div class="error" id="statuskesejahteraan_err"></div>
											</div>
										</div>
									</div>
								</li>
								<li class="mcf-item">
									<div class="title">
										<h4>II. Keterangan Perumahan</h4>
									</div>
									<div class="data uk-grid">
										@php($i = 1)
										@foreach($indivarrt as $listindirt)
										@if($listindirt->caraisi == '2')

											<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
												<div class="data-inner">
													<div>
														<label for="">{{ $i++.'. '.$listindirt->nama }}</label>
													</div>
													<div class="uk-button uk-form-select uk-active" data-uk-form-select>
														<span></span>
														<i class="uk-icon-angle-down uk-icon-medium"></i>
														<select id="{{ $listindirt->kode_variabel }}" data-status="rt" name="{{ $listindirt->kode_variabel }}">
															<option value="">Pilih </option>
															@foreach(App\Models\OpsiIndikator::getopsi($listindirt->kode_variabel) as $listopsirt)
															<option value="{{ $listopsirt->no_opsi }}" {{ ($listopsirt->no_opsi == (array_key_exists($listindirt->kode_variabel, $peserta[0]->datart[0]) ? $peserta[0]->datart[0][$listindirt->kode_variabel] : '')) ? 'selected' : '' }}>{{$listopsirt->no_opsi.'. '.$listopsirt->desc_opsi}}</option>
															@endforeach
														</select>
													</div>
													<div class="error" id="{{ $listindirt->kode_variabel }}_err"></div>

												</div>
											</div>
										@elseif($listindirt->caraisi == '1')
											<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
												<div class="data-inner">
													<div>
														<label for="rt-{{ $listindirt->kode.'-'.$listindirt->caraisi }}">{{ $i++.'. '.$listindirt->nama }}</label>
													</div>
													<div class="input-group">
														<i class="satuan">{{ $listindirt->ketsatuan }}</i>
														<input id="{{ $listindirt->kode_variabel }}" type="text" data-status="rt" name="{{ $listindirt->kode_variabel }}" value="{{ (array_key_exists($listindirt->kode_variabel, $peserta[0]->datart[0]) ? $peserta[0]->datart[0][$listindirt->kode_variabel] : '') }}" >
													</div>
													<div class="error" id="{{ $listindirt->kode_variabel }}_err"></div>
													<!-- <div class="error">Pesan Error</div> -->
												</div>
											</div>


										@else
											<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
												<div class="data-inner uk-text-left">
													<label for="">{{ $i++.'. '.$listindirt->nama }}</label>
													<div class="checkbox">
														@foreach(App\Models\OpsiIndikator::getopsi($listindirt->kode_variabel) as $listopsirt)
															<div><input id="{{ $listopsirt->kode_variabel.'_'.$listopsirt->no_opsi }}" data-status="rt"  {{ ($listopsirt->no_opsi == (array_key_exists($listindirt->kode_variabel, $peserta[0]->datart[0]) ? $peserta[0]->datart[0][$listindirt->kode_variabel] : '')) ? 'checked' : '' }}  value="{{ $listopsirt->no_opsi }}" type="checkbox" name="{{ $listindirt->kode_variabel }}"><label for="{{ $listopsirt->kode_variabel.'_'.$listopsirt->no_opsi }}">{{ $listopsirt->no_opsi.'. '.$listopsirt->desc_opsi }}</label></div>
														@endforeach
													</div>
													<div class="error" id="{{ $listindirt->kode_variabel }}_err"></div>
												</div>
											</div>
										@endif
										@endforeach

									</div>
								</li>
								<li class="mcf-item">
									<div class="submit">
										<div class="uk-clearfix">
											
											<div class="uk-float-right">
												<button type="button" id="next-rt">Selanjutnya</button>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</fieldset>

						<fieldset id="page-2">
							<ul class="mcf-list">
								<li class="mcf-item">
									<div class="title">
										<h4>III. Kepemilikan Aset Dan Keikutsertaan Program</h4>
									</div>
									<div class="data">
										<div class="data-wrapper">
											<div class="data-inner uk-text-left">
												<div class="uk-grid">
													@php($i = 1)
													@foreach($indivarasset as $listindiasset)
													@if($listindiasset->caraisi == '2')
														<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
															<div class="data-inner">
																<div>
																	<label for="">{{ $i++.'. '.$listindiasset->nama }}</label>
																</div>
																<div class="uk-button uk-form-select uk-active" data-uk-form-select>
																	<span></span>
																	<i class="uk-icon-angle-down uk-icon-medium"></i>
																	<select id="{{ $listindiasset->kode_variabel }}" data-status="asset" name="{{ $listindiasset->kode_variabel }}">
																		<option value="">Pilih </option>
																		@foreach(App\Models\OpsiIndikator::getopsi($listindiasset->kode_variabel) as $listopsiasset)
																		<option value="{{ $listopsiasset->no_opsi }}" {{ ($listopsiasset->no_opsi == (array_key_exists($listindiasset->kode_variabel, $peserta[0]->asset[0]) ? $peserta[0]->asset[0][$listindiasset->kode_variabel] : '')) ? 'selected' : '' }}>{{$listopsiasset->no_opsi.'. '.$listopsiasset->desc_opsi}}</option>
																		@endforeach
																	</select>
																</div>
																<div class="error" id="{{ $listindiasset->kode_variabel }}_err"></div>

															</div>
														</div>
													@elseif($listindiasset->caraisi == '1')
														<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
															<div class="data-inner">
																<div>
																	<label for="asset-{{ $listindiasset->kode.'-'.$listindiasset->caraisi }}">{{ $i++.'. '.$listindiasset->nama }}</label>
																</div>
																<div class="input-group">
																	<i class="satuan">{{ $listindiasset->ketsatuan }}</i>
																	<input id="{{ $listindiasset->kode_variabel }}" data-status="asset" value="{{ (array_key_exists($listindiasset->kode_variabel, $peserta[0]->asset[0]) ? $peserta[0]->asset[0][$listindiasset->kode_variabel] : '') }}" type="text" name="{{ $listindiasset->kode_variabel }}">
																</div>
																<div class="error" id="{{ $listindiasset->kode_variabel }}_err"></div>
																<!-- <div class="error">Pesan Error</div> -->
															</div>
														</div>
													@else
														<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
															<div class="data-inner uk-text-left">
																<label for="">{{ $i++.'. '.$listindiasset->nama }}</label>
																<div class="checkbox">
																	@foreach(App\Models\OpsiIndikator::getopsi($listindiasset->kode_variabel) as $listopsiasset)
																		<div><input id="{{ $listopsiasset->kode_variabel.'_'.$listopsiasset->no_opsi }}" data-status="asset" {{ ($listopsiasset->no_opsi == (array_key_exists($listindiasset->kode_variabel, $peserta[0]->asset[0]) ? $peserta[0]->asset[0][$listindiasset->kode_variabel] : '')) ? 'checked' : '' }} value="{{ $listopsiasset->no_opsi }}" type="checkbox" name="{{ $listindiasset->kode_variabel }}"><label for="{{ $listopsiasset->kode_variabel.'_'.$listopsiasset->no_opsi }}">{{ $listopsiasset->no_opsi.'. '.$listopsiasset->desc_opsi }}</label></div>
																	@endforeach
																</div>
																<div class="error" id="{{ $listindiasset->kode_variabel }}_err"></div>
															</div>
														</div>
													@endif
													@endforeach

												</div>
											</div>
										</div>
									</div>
								</li>
								<li class="mcf-item">
									<div class="submit">
										<div class="uk-clearfix">
											<div class="uk-float-left">
												<button type="button" class="f-prev" id="prev-asset">Sebelumnya</button>
											</div>
											<div class="uk-float-right">
												<button type="button" id="next-asset">Selanjutnya</button>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</fieldset>

						<fieldset id="page-3" >
							<ul id="fs-page-iv" class="daftar-input-ppfm uk-nav uk-nav-parent-icon" data-uk-nav={multiple: true}>
								<li class="uk-parent uk-active">
									<a href="#">Daftar Inputan Anggota Keluarga</a>
									<ol class="uk-nav-sub uk-nav-parent-icon" data-uk-nav={multiple: true}>
										@php($indexid = 0)
										@for($index = 0;$index < count($peserta[0]->individu);$index++)
										@php($dataart = $peserta[0]->individu[$index])
										@if($dataart['status'] == 1)
										<li class="uk-parent">
											<a href="#">{{ (array_key_exists('nama', $dataart) ? $dataart['nama'] : '').' ('.(array_key_exists('nik', $dataart) ? $dataart['nik'] : '').')' }}</a>
											<i id="delete-item-art" data-kdp="{{$peserta[0]->kodepeserta}}" data-idp="{{ (array_key_exists('_id', $dataart) ? $dataart['_id'] : '') }}" class="uk-icon-close delete-item"></i>
											<ul class="uk-nav-sub">
												<li>
													<ul class="mcf-list">
														<li class="mcf-item">
															<!-- <div class="title">
																<h4>IV. Keterangan Sosial Ekonomi Anggota Rumah Tangga</h4>
															</div>
															<div class="desc">
																<p><i>Tulis siapa saja yang biasanya tinggal dan makan di rumah tangga BAIK, DEWASA, ANAK-ANAK, MAUPUN BAYI. Tuliskan nama sesuai dengan identitas, beserta Nomor Induk Kependudukan.</i></p>
															</div> -->
															@php($i = 1)
															<div class="data uk-grid">
																<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
																	<div class="data-inner">
																		<label for="nik_{{ $indexid }}">{{$i++}}. Nomor Induk Kependudukan (NIK)</label>
																		<input id="nik_{{ $indexid }}" value="{{ (array_key_exists('nik', $dataart) ? $dataart['nik'] : '') }}" type="text" name="nik_{{ $indexid }}" maxlength="16">
																		<div class="error" id="nik_{{$indexid}}_err"></div>
																	</div>
																</div>
																<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
																	<div class="data-inner">
																		<label for="nama_{{ $indexid }}">{{$i++}}. Nama Anggota Rumah Tangga</label>
																		<input id="nama_{{ $indexid }}" type="text" value="{{ (array_key_exists('nama', $dataart) ? $dataart['nama'] : '') }}" name="nama_{{ $indexid }}">
																		<div class="error" id="nama_{{$indexid}}_err"></div>
																	</div>
																</div>
																@foreach($indivarindividu as $listindividu)
																@if($listindividu->caraisi == '2')
																	<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
																		<div class="data-inner">
																			<div>
																				<label for="">{{ $i++.'. '.$listindividu->nama }}</label>
																			</div>
																			<div class="uk-button uk-form-select uk-active" data-uk-form-select>
																				<span></span>
																				<i class="uk-icon-angle-down uk-icon-medium"></i>
																				<select id="{{ $listindividu->kode_variabel.'_'.$indexid }}" data-status="individu_{{$indexid}}" name="{{ $listindividu->kode_variabel }}">
																					<option value="">Pilih </option>
																					@foreach(App\Models\OpsiIndikator::getopsi($listindividu->kode_variabel) as $listopsiindi)
																					<option value="{{ $listopsiindi->no_opsi }}" {{ ($listopsiindi->no_opsi == (array_key_exists($listindividu->kode_variabel, $peserta[0]->individu[$indexid]) ? $peserta[0]->individu[$indexid][$listindividu->kode_variabel] : '')) ? 'selected' : '' }}>{{$listopsiindi->no_opsi.'. '.$listopsiindi->desc_opsi}}</option>
																					@endforeach
																				</select>
																			</div>
																			<div class="error" id="{{ $listindividu->kode_variabel.'_'.$indexid }}_err"></div>

																		</div>
																	</div>
																@elseif($listindividu->caraisi == '1')
																	<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
																		<div class="data-inner">
																			<div>
																				<label for="asset-{{ $listindividu->kode.'-'.$listindividu->caraisi }}">{{ $i++.'. '.$listindividu->nama }}</label>
																			</div>
																			<div class="input-group">
																				<i class="satuan">{{ $listindividu->ketsatuan }}</i>
																				<input id="{{ $listindividu->kode_variabel.'_'.$indexid }}" data-status="individu_{{$indexid}}" value="{{ (array_key_exists($listindividu->kode_variabel, $peserta[0]->individu[$indexid]) ? $peserta[0]->individu[$indexid][$listindividu->kode_variabel] : '') }}" type="text" name="{{ $listindividu->kode_variabel }}">
																			</div>
																			<div class="error" id="{{ $listindividu->kode_variabel.'_'.$indexid }}_err"></div>
																			<!-- <div class="error">Pesan Error</div> -->
																		</div>
																	</div>
																@else
																	<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
																		<div class="data-inner uk-text-left">
																			<label for="">{{ $i++.'. '.$listindividu->nama }}</label>
																			<div class="checkbox">
																				@foreach(App\Models\OpsiIndikator::getopsi($listindividu->kode_variabel) as $listopsiindi)
																					<div><input id="{{ $listopsiindi->kode_variabel.'_'.$listopsiindi->no_opsi.'_'.$indexid }}" data-status="individu_{{$indexid}}" {{ ($listopsiindi->no_opsi == (array_key_exists($listindividu->kode_variabel, $peserta[0]->individu[$indexid]) ? $peserta[0]->individu[$indexid][$listindividu->kode_variabel] : '')) ? 'checked' : '' }} value="{{ $listopsiindi->no_opsi }}" type="checkbox" name="{{ $listindividu->kode_variabel }}"><label for="{{ $listopsiindi->kode_variabel.'_'.$listopsiindi->no_opsi.'_'.$indexid }}">{{ $listopsiindi->no_opsi.'. '.$listopsiindi->desc_opsi }}</label></div>
																				@endforeach
																			</div>
																			<div class="error" id="{{ $listindividu->kode_variabel.'_'.$indexid }}_err"></div>
																		</div>
																	</div>
																@endif
																@endforeach

															</div>
														</li>
														
														<li class="mcf-item">
															<div id="alert-add-art_{{ $indexid }}" class="uk-alert uk-alert-large uk-hidden" data-uk-alert>
																<p></p>
															</div>
														</li>
														<li>
															<div class="uk-clearfix">
																<div class="uk-float-right">
																	<button class="button-save" type="button" data-id="{{ $indexid }}" data-kdp="{{$peserta[0]->kodepeserta}}" data-idp="{{$peserta[0]->individu[$indexid]['_id']}}" id="btn-save">Simpan</button>
																</div>
															</div>
														</li>
													</ul>
												</li>
											</ul>
										</li>
										@php($indexid++)
										@endif
										@endfor
									</ol>
								</li>
							</ul>
							<ul class="mcf-list">
								<li class="mcf-item">
									<div class="title">
										<h4>IV. Keterangan Sosial Ekonomi Anggota Rumah Tangga</h4>
									</div>
									<div class="desc">
										<p><i>Tulis siapa saja yang biasanya tinggal dan makan di rumah tangga BAIK, DEWASA, ANAK-ANAK, MAUPUN BAYI. Tuliskan nama sesuai dengan identitas, beserta Nomor Induk Kependudukan.</i></p>
									</div>
									@php($i = 1)
									<div class="data uk-grid">
										<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
											<div class="data-inner">
												<label for="nik">{{$i++}}. Nomor Induk Kependudukan (NIK)</label>
												<input id="nik" value="" type="text" name="nik" maxlength="16">
												<div class="error" id="nik_err"></div>
											</div>
										</div>
										<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
											<div class="data-inner">
												<label for="nama">{{$i++}}. Nama Anggota Rumah Tangga</label>
												<input id="nama" type="text" value="" name="nama">
												<div class="error" id="nama_err"></div>
											</div>
										</div>

										@foreach($indivarindividu as $listindividu)
										@if($listindividu->caraisi == '2')
											<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
												<div class="data-inner">
													<div>
														<label for="">{{ $i++.'. '.$listindividu->nama }}</label>
													</div>
													<div class="uk-button uk-form-select uk-active" data-uk-form-select>
														<span></span>
														<i class="uk-icon-angle-down uk-icon-medium"></i>
														<select id="{{ $listindividu->kode_variabel }}" data-status="individu" name="{{ $listindividu->kode_variabel }}">
															<option value="">Pilih </option>
															@foreach(App\Models\OpsiIndikator::getopsi($listindividu->kode_variabel) as $listopsiindi)
															<option value="{{ $listopsiindi->no_opsi }}">{{$listopsiindi->no_opsi.'. '.$listopsiindi->desc_opsi}}</option>
															@endforeach
														</select>
													</div>
													<div class="error" id="{{ $listindividu->kode_variabel }}_err"></div>

												</div>
											</div>
										@elseif($listindividu->caraisi == '1')
											<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
												<div class="data-inner">
													<div>
														<label for="asset-{{ $listindividu->kode.'-'.$listindividu->caraisi }}">{{ $i++.'. '.$listindividu->nama }}</label>
													</div>
													<div class="input-group">
														<i class="satuan">{{ $listindividu->ketsatuan }}</i>
														<input id="{{ $listindividu->kode_variabel }}" data-status="individu" value="" type="text" name="{{ $listindividu->kode_variabel }}">
													</div>
													<div class="error" id="{{ $listindividu->kode_variabel }}_err"></div>
													<!-- <div class="error">Pesan Error</div> -->
												</div>
											</div>
										@else
											<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
												<div class="data-inner uk-text-left">
													<label for="">{{ $i++.'. '.$listindividu->nama }}</label>
													<div class="checkbox">
														@foreach(App\Models\OpsiIndikator::getopsi($listindividu->kode_variabel) as $listopsiindi)
															<div><input id="{{ $listopsiindi->kode_variabel.'_'.$listopsiindi->no_opsi }}" data-status="individu" value="{{ $listopsiindi->no_opsi }}" type="checkbox" name="{{ $listindividu->kode_variabel }}"><label for="{{ $listopsiindi->kode_variabel.'_'.$listopsiindi->no_opsi }}">{{ $listopsiindi->no_opsi.'. '.$listopsiindi->desc_opsi }}</label></div>
														@endforeach
													</div>
													<div class="error" id="{{ $listindividu->kode_variabel.'_'.$indexid }}_err"></div>
												</div>
											</div>
										@endif
										@endforeach
									</div>
								</li>

								<li class="mcf-item">
									<div id="alert-add-art" class="uk-alert uk-alert-large uk-hidden" data-uk-alert>
										<p></p>
									</div>
								</li>

								<li class="mcf-item">
									<div class="submit">
										<div class="uk-clearfix">
											<div class="uk-float-right">
												<button type="button" data-kdp="{{ $peserta[0]->kodepeserta }}" class="f-tambah-data">Tambah Data</button>
											</div>
										</div>
									</div>
								</li>
								<li class="mcf-item">
									<div id="alert-add-ppfm" class="uk-alert uk-alert-large uk-hidden" data-uk-alert>
										<p></p>
									</div>
								</li>
								<li class="mcf-item">
									<div class="submit">
										<div class="uk-clearfix">
											<div class="uk-float-left">
												<button type="button" id="prev-tanggungan" class="f-prev">Sebelumnya</button>
											</div>
											<div class="uk-float-right">
												<button type="submit" id="submit-perubahan" data-id="{{ $peserta[0]->_id }}" class="f-submit">Simpan</button>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</fieldset>
						{{-- <fieldset id="page-4" >
							<ul id="fs-page-iv-2" class="daftar-input-ppfm uk-nav uk-nav-parent-icon" data-uk-nav={multiple: true}>
								<li class="uk-parent uk-active">
									<a href="#">Daftar Inputan Anggota Keluarga 2</a>
									<ol class="uk-nav-sub uk-nav-parent-icon" data-uk-nav={multiple: true}>
										@php($indid = 0)
										@for($ind = 0; $ind < count($peserta[0]->tanggungan);$ind++)
										@php($datatanggungan = $peserta[0]->tanggungan[$ind])
										@if($datatanggungan['status'] == 1)
										<li class="uk-parent">
											<a href="#">{{ (array_key_exists('nama', $datatanggungan) ? $datatanggungan['nama'] : '').' ('.(array_key_exists('nik', $datatanggungan) ? $datatanggungan['nik'] : '').')' }}</a>
											<i id="delete-item-tanggungan" data-kdp="{{ $peserta[0]->kodepeserta }}" data-nik="{{ (array_key_exists('nik', $datatanggungan) ? $datatanggungan['nik'] : '') }}" class="uk-icon-close delete-item"></i>
											<ul class="uk-nav-sub">
												<li>
													<ul class="mcf-list">
														<li class="mcf-item">
															<div class="desc-2">
																<p><i>Apakah Ada Anak Dari Kepala Keluarga Yang Masih Menjadi Tanggungan Tetapi Sedang Sekolah / Kuliah & Tidak Tinggal Dalam Ruta Ini? Jika ada, sebutkan</i></p>
															</div>
														</li>
														<li class="mcf-item">
															<div class="data uk-grid">
																<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
																	<div class="data-inner">
																		<label for="nik-t-iv_{{$indid}}">1. Nomor Induk Kependudukan (NIK)</label>
																		<input id="nik-t-iv_{{$indid}}" maxlength="16" data-form-iv="nik-t-iv" value="{{ (array_key_exists('nik', $datatanggungan) ? $datatanggungan['nik'] : '') }}" type="text" name="nik-t-iv">
																	</div>
																</div>
																<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
																	<div class="data-inner">
																		<label for="nama-t-iv_{{$indid}}">2. Nama</label>
																		<input id="nama-t-iv_{{$indid}}" data-form-iv="nama-t-iv" type="text" value="{{ (array_key_exists('nama', $datatanggungan) ? $datatanggungan['nama'] : '') }}" name="nama-t-iv">
						
																	</div>
																</div>
																<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
																	<div class="data-inner">
																		<label for="alamat-t-iv_{{$indid}}">3. Alamat Tempat Tinggal</label>
																		<input id="alamat-t-iv_{{$indid}}" data-form-iv="alamat-t-iv" type="text" name="alamat-t-iv" value="{{ (array_key_exists('alamat', $datatanggungan) ? $datatanggungan['alamat'] : '') }}">
						
																	</div>
																</div>
																<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
																	<div class="data-inner">
																		<label for="nama-sekolah-t-iv_{{$indid}}">4. Nama Sekolah</label>
																		<input id="nama-sekolah-t-iv_{{$indid}}" data-form-iv="nama-sekolah-t-iv" type="text" name="nama-sekolah-t-iv" value="{{ (array_key_exists('namasekolah', $datatanggungan) ? $datatanggungan['namasekolah'] : '') }}">
						
																	</div>
																</div>
																<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
																	<div class="data-inner">
																		<label for="nisn-t-iv_{{$indid}}">5. NISN / NO KTM</label>
																		<input id="nisn-t-iv_{{$indid}}" data-form-iv="nisn-t-iv" type="text" name="nisn-t-iv" value="{{ (array_key_exists('nisn', $datatanggungan) ? $datatanggungan['nisn'] : '') }}">
																	</div>
																</div>
															</div>
														</li>
														<li class="mcf-item">
															<div id="alert-add-tanggungan_{{$indid}}" class="uk-alert uk-alert-large uk-hidden" data-uk-alert>
																<p></p>
															</div>
														</li>
														<li>
															<div class="uk-clearfix">
																<div class="uk-float-right">
																	<button class="button-save" type="button" data-id="{{$indid}}" data-kdp="{{$peserta[0]->kodepeserta}}" id="btn-save-tanggungan">Simpan</button>
																</div>
															</div>
														</li>
													</ul>
												</li>
											</ul>
										</li>
										@php($indid++)
										@endif
										@endfor
									</ol>
								</li>
							</ul>
							<ul class="mcf-list">
						
								<li class="mcf-item">
									<div class="desc-2">
										<p><i>Apakah Ada Anak Dari Kepala Keluarga Yang Masih Menjadi Tanggungan Tetapi Sedang Sekolah / Kuliah & Tidak Tinggal Dalam Ruta Ini? Jika ada, sebutkan</i></p>
									</div>
								</li>
								<li class="mcf-item">
									<div class="data uk-grid">
										<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
											<div class="data-inner">
												<label for="nik-t-iv">1. Nomor Induk Kependudukan (NIK)</label>
												<input id="nik-t-iv" maxlength="16" data-form-iv="nik-t-iv" type="text" name="nik-t-iv">
												<div class="error" id="nik-t-iv_err"></div>
											</div>
										</div>
						
										<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
											<div class="data-inner">
												<label for="nama-t-iv">2. Nama</label>
												<input id="nama-t-iv" data-form-iv="nama-t-iv" type="text" name="nama-t-iv">
												<div class="error" id="nama-t-iv_err"></div>
											</div>
										</div>
										<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
											<div class="data-inner">
												<label for="alamat-t-iv">3. Alamat Tempat Tinggal</label>
												<input id="alamat-t-iv" data-form-iv="alamat-t-iv" type="text" name="alamat-t-iv">
												<div class="error" id="alamat-t-iv_err"></div>
											</div>
										</div>
										<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
											<div class="data-inner">
												<label for="nama-sekolah-t-iv">4. Nama Sekolah</label>
												<input id="nama-sekolah-t-iv" data-form-iv="nama-sekolah-t-iv" type="text" name="nama-sekolah-t-iv">
												<div class="error" id="nama-sekolah-t-iv_err"></div>
											</div>
										</div>
										<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
											<div class="data-inner">
												<label for="nisn-t-iv">5. NISN / NO KTM</label>
												<input id="nisn-t-iv" data-form-iv="nisn-t-iv" type="text" name="nisn-t-iv">
												<div class="error" id="nisn-t-iv_err"></div>
											</div>
										</div>
									</div>
								</li>
								<li class="mcf-item">
									<div id="alert-add-tanggungan" class="uk-alert uk-alert-large uk-hidden" data-uk-alert>
										<p></p>
									</div>
								</li>
								<li class="mcf-item">
									<div class="submit">
										<div class="uk-clearfix">
											<div class="uk-float-right">
												<button type="button" data-kdp="{{ $peserta[0]->kodepeserta }}" class="f-tambah-data">Tambah Data</button>
											</div>
										</div>
									</div>
								</li>
								<li class="mcf-item">
									<div id="alert-add-ppfm" class="uk-alert uk-alert-large uk-hidden" data-uk-alert>
										<p></p>
									</div>
								</li>
								<li class="mcf-item">
									<div class="submit">
										<div class="uk-clearfix">
											<div class="uk-float-left">
												<button type="button" id="prev-tanggungan" class="f-prev">Sebelumnya</button>
											</div>
											<div class="uk-float-right">
												<button type="submit" id="submit-perubahan" data-id="{{ $peserta[0]->_id }}" class="f-submit">Simpan</button>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</fieldset> --}}

					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	var sidebar = 'sidebar-fppfm-sudah';
</script>

<script src="{{ URL('/assets/js/backend/ppfm.js') }}"></script>
@stop
