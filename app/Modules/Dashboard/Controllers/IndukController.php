<?php

namespace App\Modules\Dashboard\Controllers;

use Illuminate\Http\Request;
use App\Models\PesertaMpm;
use App\Models\IndikatorVariabel;
use App\Models\OpsiIndikator;
use App\Models\PesertaTanggungan;
use App\Models\PesertaBDT;
use App\Models\PesertaBDTOld;
use App\Models\RtVariabel;
use App\Models\AssetVariabel;
use App\Http\Requests;
use App\Models\Kelurahan;
use App\Models\Kecamatan;
use App\Http\Controllers\Controller;

class IndukController extends Controller
{

	public function index(){
		$kec = empty($_GET['kec']) ? '' : $_GET['kec'];
		$getkecamatan = Kecamatan::where('id_kota', '7316')->where('status', '1')->get();

		if(empty($kec)){
			$peserta_bdt = PesertaBDT::where('status', 1)->orderBy('_id', 'ASC')->paginate(50);
			$peserta_count = PesertaBDT::where('status', 1)->orderBy('_id', 'ASC')->count();
		}else{
			$peserta_bdt = PesertaBDT::where('status', 1)->where('kecamatan', $kec)->orderBy('_id', 'ASC')->paginate(50);
			$peserta_count = PesertaBDT::where('status', 1)->where('kecamatan', $kec)->orderBy('_id', 'ASC')->count();
		}
		
		return view('Dashboard::pages.induk.individu', ['peserta' => $peserta_bdt, 'kecamatan' => $getkecamatan, 'jumpeserta' => $peserta_count]);
	}

	public function individudetail($idpeserta){
		$getbdt = PesertaBDT::where('_id', $idpeserta)->where('status', 1)->first();

		$peserta_count = PesertaBDT::raw(function($collection) use($idpeserta) {
			return $collection->aggregate(array(
				array( '$unwind' => '$individu'
				),
				array( '$match' => array(
					'_id' => new \MongoDB\BSON\ObjectID($idpeserta),
					'individu.status' => 1
				)),
				array(
					'$count' => 'count'
				)
			));
		});

		return view('Dashboard::pages.induk.individu-detail', ['peserta' => $getbdt, 'jumpeserta' => $peserta_count]);
	}

	public function individudetailart($kodepeserta, $idpeserta){
		$peserta_indi = PesertaBDT::raw(function($collection) use($kodepeserta, $idpeserta) {
			return $collection->aggregate(array(
				array( '$unwind' => '$individu'
				),
				array( '$match' => array(
					'individu.kodepeserta' => $kodepeserta,
					'individu.nik' => $idpeserta,
					'individu.status' => 1
				))
			));
		});

		$peserta_old = PesertaBDTOld::raw(function($collection) use($kodepeserta, $idpeserta) {
			return $collection->aggregate(array(
				array( '$unwind' => '$individu'
				),
				array( '$match' => array(
					'individu.kodepeserta' => $kodepeserta,
					'individu.nik' => $idpeserta,
					'individu.status' => 1
				))
			));
		});

		$indivarindividu = IndikatorVariabel::where('tingkat', '1')->where('verifikasi', '1')->whereNotIn('kode_variabel', ['nama', 'nik'])->where('status', 1)->get();
		
		return view('Dashboard::pages.induk.individu-art-detail', ['peserta' => $peserta_indi, 'peserta_old' => $peserta_old, 'indivar' => $indivarindividu]);
	}

	public function indexrt(){
		$kec = empty($_GET['kec']) ? '' : $_GET['kec'];
		$getkecamatan = Kecamatan::where('id_kota', '7316')->where('status', '1')->get();

		if(empty($kec)){
			$peserta_bdt = PesertaBDT::where('status', 1)->orderBy('_id', 'ASC')->paginate(50);
			$peserta_count = PesertaBDT::where('status', 1)->orderBy('_id', 'ASC')->count();
		}else{
			$peserta_bdt = PesertaBDT::where('status', 1)->where('kecamatan', $kec)->orderBy('_id', 'ASC')->paginate(50);
			$peserta_count = PesertaBDT::where('status', 1)->where('kecamatan', $kec)->orderBy('_id', 'ASC')->count();
		}
		
		return view('Dashboard::pages.induk.rt', ['peserta' => $peserta_bdt, 'kecamatan' => $getkecamatan, 'jumpeserta' => $peserta_count]);
	}

	public function rumahtanggadetail($kodepeserta){
		$peserta = PesertaBDT::where('kodepeserta', $kodepeserta)->where('status', 1)->first();
		$peserta_old = PesertaBDTOld::where('kodepeserta', $kodepeserta)->where('status', 1)->first();
		$indivarrt = IndikatorVariabel::where('tingkat', '2')->whereNotIn('kode_variabel', ['b1_k6', 'b1_k9', 'b1_k10', 'b1_k8', 'statuskesejahteraan'])->where('verifikasi', '1')->where('status', 1)->get();
		$indivarasset = IndikatorVariabel::where('tingkat', '3')->where('verifikasi', '1')->where('status', 1)->get();
		return view('Dashboard::pages.induk.rt-detail', ['peserta' => $peserta, 'peserta_old' => $peserta_old, 'indivarrt' => $indivarrt, 'indivarasset' => $indivarasset]);

	}
}