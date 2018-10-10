<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Detail Peserta MPM</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="{{ URL('/assets/stylesheets/base.css') }}">
	<link rel="stylesheet" href="{{ URL('/assets/stylesheets/fonts.css') }}">
	<link rel="stylesheet" href="{{ URL('/assets/stylesheets/main.css') }}">
	<link rel="stylesheet" href="{{ URL('/assets/stylesheets/jquery-ui.min.css') }}">
	<link rel="stylesheet" href="{{ URL('/assets/stylesheets/MonthPicker.css') }}">

</head>
<body>
	<nav class="print-page">
		<div class="title">
			<h2>SIPAKATAU ( Sistem Informasi Penanggulangan Kemiskinan Terpadu )</h2>
		</div>
	</nav>
	<div class="main-cetak-table print-page">
		<div class="table-desc">
			<div class="uk-clearfix">
				<div class="uk-float-left">
					<h4>Daftar sasaran verifikasi rumah tangga belum terdaftar dalam PPFM</h4>
				</div>
				<div class="uk-float-right">
					<p class="cetak-date"></p>
					<script>
						var d = new Date();
						$('.cetak-date').text(d.toLocaleDateString());
					</script>
				</div>
			</div>
		</div>
		<table id="table-ppfm" class="uk-table uk-table-hover">
			<thead>
				<tr>
					<th>No.</th>
					<th>Kecamatan</th>
					<th>Kelurahan / Desa</th>
					<th>Nama Jalan RT / RW</th>
					<th>NIK</th>
					<th>Nama Lengkap Sesuai KTP</th>
					<th>Nomor KK</th>
					<th>Nama Kepala Ruta</th>
					<th>Status Pekerjaan Kepala Ruta</th>
					<th>Jumlah Anggota Ruta</th>
					<th>Jenis Kelamin</th>
					<th>Bulan & Tahun Lahir</th>
					<th>Hubungan Dengan Kepala Ruta</th>
					<th>Hubungan Dengan Kepala Keluarga</th>
				</tr>
			</thead>
			<tbody>
			@php($i = empty($_GET['page']) ? 1 : ((($_GET['page'] - 1) * 50) + 1))
				@foreach($peserta as $listpeserta)
				@php($ruta = App\Models\PesertaIndividu::getruta($listpeserta->kodepeserta))
				@php($pendaftar = App\Models\PesertaPendaftar::getpeserta($listpeserta->kodepeserta))
				@if(App\Models\IndikatorVariabel::getskrining($listpeserta->kodepeserta) == false)
				<tr>
					<td>{{ $i++.' .' }}</td>
					<td>{{ ucwords(strtolower(App\Models\Kecamatan::getkecamatan($listpeserta->kecamatan))) }}</td>
					<td>{{ ucwords(strtolower(App\Models\Kelurahan::getkelurahan($listpeserta->kelurahan))) }}</td>
					<td>{{ $listpeserta->alamat }}</td>
					<td>{{ $pendaftar[0]->nik }}</td>
					<td>{{ $pendaftar[0]->nama }}</td>
					<td>{{ $listpeserta->nokk }}</td>
					<td>{{ $ruta[0]->nama }}</td>
					<td>{{ ($ruta[0]->statusbekerja == '1') ? 'Bekerja' : 'Tidak Bekerja' }}</td>
					<td>{{ $listpeserta->jumart.' ' }}Orang</td>
					<td>{{ ($ruta[0]->jenkel == '1') ? 'Laki-laki' : 'Perempuan' }}</td>
					<td>{{ $ruta[0]->btl }}</td>
					<td>{{ App\Models\OpsiIndikator::getopsivar('spkt2', $pendaftar[0]->spkt2) }}</td>
					<td>{{ App\Models\OpsiIndikator::getopsivar('spkt1', $pendaftar[0]->spkt1) }}</td>
				</tr>
				@endif
				@endforeach
			</tbody>
		</table>
	</div>
	<footer class="print-page">
		<div class="uk-clearfix">
			<div class="uk-float-left">
				<p>2017 Bappeda Kabupaten Soppeng</p>
			</div>
			<div class="uk-float-right">
				<p>1</p>
			</div>
		</div>
	</footer>
</body>
</html>