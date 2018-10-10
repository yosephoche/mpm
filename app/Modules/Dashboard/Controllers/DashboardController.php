<?php

namespace App\Modules\Dashboard\Controllers;

use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\IndikatorVariabel;
use App\Models\IndividuVariabel;
use App\Models\OpsiIndikator;
use App\Models\PesertaMpm;
use App\Models\PesertaBDT;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class DashboardController extends Controller
{
	public function index(){
		$pesertajum = PesertaBDT::raw(function($collection) {
			return $collection->aggregate(array(
				array( '$match' => array(
					'kab'=> '7316'
				)),
				array( '$unwind' => '$individu'
				),
				array( '$match' => array(
					'individu.status' => 1
				)),
                array( '$count'=> 'count' )
			));
		});

		$rtjum = PesertaBDT::where('kab', '7316')->where('status', 1)->count();

		return view('Dashboard::pages.dashboard.index', ['pesertajum' => $pesertajum, 'rtjum' => $rtjum]);
	}

	public function pertanyaan(){
		return view('Dashboard::pages.master.pertanyaan');
	}

	public function getsummary(){
		$baroko = PesertaBDT::getsummary('baroko', '7316053');
		$malle = PesertaBDT::getsummary('malle', '7316052');
		$alla = PesertaBDT::getsummary('alla', '7316050');
		$curio = PesertaBDT::getsummary('curio', '7316051');
		$angoraja = PesertaBDT::getsummary('angoraja', '7316040');
		$malua = PesertaBDT::getsummary('malua', '7316041');
		$baraka = PesertaBDT::getsummary('baraka', '7316030');
		$enrekang = PesertaBDT::getsummary('enrekang', '7316020');
		$buntubatu = PesertaBDT::getsummary('buntubatu', '7316031');
		$bungin = PesertaBDT::getsummary('bungin', '7316011');
		$cendana = PesertaBDT::getsummary('cendana', '7316021');
		$maiwa = PesertaBDT::getsummary('maiwa', '7316010');

		$data = array($baroko, $malle, $alla, $curio, $angoraja, $malua, $baraka, $enrekang, $buntubatu, $bungin, $cendana, $maiwa);
		return json_encode(array('message' => 'ok', 'data' => json_encode($data)));
	}
}
