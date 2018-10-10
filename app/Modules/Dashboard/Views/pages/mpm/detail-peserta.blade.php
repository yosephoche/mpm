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
			<h2>Pendaftaran MPM</h2>
		</div>
	</div>
	<div class="mc-breadcrumb" data-uk-sticky="{top:60}">
        <ul class="uk-breadcrumb">
            <li><a href="javascript:;">Pendaftaran</a></li>
			<li><a href="{{ URL('/mpm') }}">Daftar Peserta MPM</a></li>
            <li><a href="javascript:;">Detail Peserta MPM</a></li>
        </ul>
    </div>

    <div class="mc-form">
        <div class="mc-form-wrapper">
            <div class="mc-form-inner">
                <div class="mcf-detail-page">
                    <div class="mcf-content">
                        <div class="mcf-title">
                            <h3>Rincian Peserta Pendaftaran Rumah Tangga Miskin Dan Kurang Mampu</h3>
                        </div>
                        <ul class="mcf-list">
                            <li class="mcf-item">
                                <div class="title">
                                    <h4>I. Rincian Informasi Pendaftaran</h4>
                                </div>
                                @php($i = 1)
                                <div class="data uk-grid">
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="nomorKk">{{$i++}}. Nomor Kartu Keluarga</label>
                                            <input id="nomorKk" type="text" name="nomorKk" value="{{ $peserta[0]->nokk }}" readonly />
                                        </div>
                                    </div>
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="nik">{{$i++}}. NIK (Nomor Induk Kependudukan)</label>
                                            <input id="nik" type="text" name="nik" readonly value="{{ $peserta[0]->pendaftar[0]['nik'] }}">
                                        </div>
                                    </div>
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="namaLengkap">{{$i++}}. Nama Lengkap Sesuai KTP)</label>
                                            <input id="namaLengkap" type="text" name="namaLengkap" value="{{ $peserta[0]->pendaftar[0]['nama'] }}" readonly>
                                        </div>
                                    </div>
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="jenis-kelamin">{{$i++}}. Jenis Kelamin</label>
                                            <input id="jenis-kelamin" type="text" name="jenis-kelamin" value="{{ ($peserta[0]->pendaftar[0]['jenkel'] == '1') ? 'Laki-laki' : 'Perempuan' }}" readonly>
                                        </div>
                                    </div>
                                    @foreach(App\Models\IndikatorVariabel::getVariabelIndividu() as $key => $listindi)
                                    @php($kodeindividu = $listindi->kode)
                                    @if(!empty($peserta[0]->pendaftar[0][$kodeindividu]))
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="{{$listindi->kode}}">{{ $i++ .'. '.App\Models\IndikatorVariabel::getvariabel($listindi->kode) }}</label>
                                            <input id="{{$listindi->kode}}" type="text" name="{{$key}}" value="{{ App\Models\OpsiIndikator::getopsivar($listindi->kode, $peserta[0]->pendaftar[0][$kodeindividu]) }}" readonly>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach

                                    @php($hubkk = App\Models\IndikatorVariabel::getIndikatorVar('b4_k5'))
                                    @if($hubkk)
                                    @if(!empty($peserta[0]->pendaftar[0]['b4_k5']))
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="{{$hubkk->kode_variabel}}">{{ $i++ .'. '.App\Models\IndikatorVariabel::getvariabel($hubkk->kode_variabel) }}</label>
                                            <input id="{{$hubkk->kode_variabel}}" type="text" name="" value="{{ App\Models\OpsiIndikator::getopsivar($hubkk->kode_variabel, $peserta[0]->pendaftar[0]['b4_k5']) }}" readonly>
                                        </div>
                                    </div>
                                    @endif
                                    @endif
                                    @php($hubrt = App\Models\IndikatorVariabel::getIndikatorVar('b4_k3'))
                                    @if($hubrt)
                                    @if(!empty($peserta[0]->pendaftar[0]['b4_k3']))
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="{{$hubrt->kode_variabel}}">{{ $i++ .'. '.App\Models\IndikatorVariabel::getvariabel($hubrt->kode_variabel) }}</label>
                                            <input id="{{$hubrt->kode_variabel}}" type="text" name="" value="{{ App\Models\OpsiIndikator::getopsivar($hubrt->kode_variabel, $peserta[0]->pendaftar[0]['b4_k3']) }}" readonly>
                                        </div>
                                    </div>
                                    @endif
                                    @endif
                                </div>
                            </li>
                            <li class="mcf-item">
                                <div class="title">
                                    <h4>II. Rincian Infomasi Rumah Tangga</h4>
                                </div>
                                <div class="data uk-grid">
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="nikKepRt">{{$i++}}. NIK Kepala Rumah Tangga</label>
                                            <input id="nikKepRt" type="text" name="nikKepRt" value="{{ App\Models\PesertaMpm::getkrt($peserta[0]->kodepeserta)[0]['nik'] }}" readonly>

                                        </div>
                                    </div>
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="namaKepRt">{{$i++}}. Nama Kepala Rumah Tangga</label>
                                            <input id="namaKepRt" type="text" name="namaKepRt" value="{{ App\Models\PesertaMpm::getkrt($peserta[0]->kodepeserta)[0]['nama'] }}" readonly>
                                        </div>
                                    </div>
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="namaKepRt">{{$i++}}. Jenis Kelamin</label>
                                            <input id="namaKepRt" type="text" name="namaKepRt" value="{{ (App\Models\PesertaMpm::getkrt($peserta[0]->kodepeserta)[0]['b4_k6'] == '1') ? 'Laki-laki' : 'Perempuan' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="btl-rt">{{$i++}}. Umur Kepala Rumah Tangga</label>
                                            <input id="btl-rt" type="text" name="btl-rt" value="{{ App\Models\PesertaMpm::getkrt($peserta[0]->kodepeserta)[0]['b4_k7'] }}" readonly>
                                        </div>
                                    </div>
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="pekerjaan-kep-rt">{{$i++}}. Status Pekerjaan Kepala Rumah Tangga</label>
                                            <input id="pekerjaan-kep-rt" type="text" name="pekerjaan-kep-rt" value="{{ (App\Models\PesertaMpm::getkrt($peserta[0]->kodepeserta)[0]['statusbekerja'] == '1') ? 'Bekerja' : 'Tidak Bekerja' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="jumAngKel">{{$i++}}. Jumlah Anggota Keluarga</label>
                                            <input id="jumAngKel" type="text" name="jumAngKel" value="{{ $peserta[0]->b1_k9 }}" readonly>

                                        </div>
                                    </div>
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="namaJalan">{{$i++}}. Nama Jalam / (RT/RW)</label>
                                            <input id="namaJalan" type="text" name="namaJalan" value="{{ $peserta[0]->b1_k6 }}" readonly>

                                        </div>
                                    </div>
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="kecamatan">{{$i++}}. Kecamatan</label>
                                            <input id="kecamatan" type="text" name="kecamatan" value="{{ App\Models\Kecamatan::getkecamatan($peserta[0]->kec) }}" readonly>
                                        </div>
                                    </div>
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="lurahDesa">{{$i++}}. Kelurahan / Desa</label>
                                            <input id="lurahDesa" type="text" name="lurahDesa" value="{{ App\Models\Kelurahan::getkelurahan($peserta[0]->des) }}" readonly>

                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="mcf-item">
                                <div class="title">
                                    <h4>III. Rincian Informasi Bangunan Tempat Tinggal</h4>
                                </div>
                                <div class="data uk-grid">
                                    @foreach(App\Models\IndikatorVariabel::getVariabelRt() as $key => $listrt)
                                    @php($kodert = $listrt->kode_variabel)
                                    @if(!empty($peserta[0]->datart[0][$kodert]))
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="{{$listrt->kode}}">{{ $i++ .'. '.App\Models\IndikatorVariabel::getvariabel($listrt->kode_variabel) }}</label>
                                            <input id="{{$listrt->kode}}" type="text" name="{{$key}}" value="{{ App\Models\OpsiIndikator::getopsivar($listrt->kode_variabel, $peserta[0]->datart[0][$kodert]) }}" readonly>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach

                                    @foreach(App\Models\IndikatorVariabel::getVariabelAsset() as $key => $listasset)
                                    @php($kodeasset = $listasset->kode_variabel)
                                    @if(!empty($peserta[0]->asset[0][$kodeasset]))
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="{{$listasset->kode}}">{{ $i++ .'. '.App\Models\IndikatorVariabel::getvariabel($listasset->kode_variabel) }}</label>
                                            <input id="{{$listasset->kode}}" type="text" name="{{$key}}" value="{{ App\Models\OpsiIndikator::getopsivar($listasset->kode_variabel, $peserta[0]->asset[0][$kodeasset]) }}" readonly>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach

                                    @if(!empty($peserta[0]->pendidikanart))
                                    <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="data-inner">
                                            <label for="{{$listasset->kode}}">{{ $i++ .'. Pendidikan tertinggi ART yang tidak bersekolah' }}</label>
                                            <input id="{{$listasset->kode}}" type="text" name="{{$key}}" value="{{ App\Models\OpsiIndikator::getopsivar('b4_k18', $peserta[0]->pendidikanart) }}" readonly>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
	var sidebar = 'pendaftaran-mpm';
</script>

<script src="{{ URL('/assets/js/backend/mpm.js') }}"></script>
@stop
