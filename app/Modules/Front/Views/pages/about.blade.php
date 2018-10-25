@extends('Front::layouts.main-about')

@section('content')
<div class="title-header uk-text-center">
        <a href="/"><h2>Si EMAS Terpadu(Sistem Informasi Pengetasan Kemiskinan Terpadu)</h2></a>
    </div>
    <div class="about-content">
        <div class="uk-width-7-10 uk-container-center">
            <div class="uk-grid">
                <div class="uk-width-large-3-10">
                    <img src="{{ URL('/assets/img/about-img.jpg') }}" alt="">
                </div>
                <div class="uk-width-large-7-10">
                    <p>Si EMAS Terpadu adalah <i>Sistem Informasi Penanggulangan Kemiskinan
Terpadu</i> pada Kabupaten Enrekang. Aplikasi Si EMAS Terpadu berfungsi 
sebagai basis data informasi online yang berfungsi sebagai acuan
data rumah tangga dan individu kurang mampu penerima bantuan
program perlindungan sosial di Kabupaten Enrekang. Aplikasi 
Si EMAS Terpadu juga berfungsi sebagai sarana pemuktahiran data  
penerima bantuan program perlindungan sosial secara online.</p>
                </div>
            </div>
        </div>
    </div>
    <style>
		.about-nav {
		    background: url(/assets/img/about-bg.jpg) no-repeat center center;
		}
    </style>
@stop