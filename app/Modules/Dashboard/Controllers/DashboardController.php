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
use Illuminate\Pagination\Paginator;
//use Jenssegers\Mongodb\Collection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardController extends Controller
{
	public function index(){
		if(auth()->guard('admin')->user()->status_admin == 2){
			$kec = auth()->guard('admin')->user()->kec;
			$pesertajum = PesertaBDT::raw(function($collection) use ($kec) {
				return $collection->aggregate(array(
					array( '$match' => array(
						'kab'=> '7316',
						'kec'=>$kec
					)),
					array( '$unwind' => '$individu'
					),
					array( '$match' => array(
						'individu.status' => 1
					)),
					array( '$count'=> 'count' )
				));
			});
			$rtjum = PesertaBDT::where('kab', '7316')->where('kec', $kec)->where('status', 1)->count();

			$pesertajummpm = PesertaMpm::raw(function($collection) use ($kec) {
				return $collection->aggregate(array(
					array( '$match' => array(
						'kab'=> '7316',
						'kec'=>$kec
					)),
					array( '$unwind' => '$individu'
					),
					array( '$match' => array(
						'individu.status' => 1
					)),
					array( '$count'=> 'count' )
				));
			});
			$rtjummpm = PesertaMpm::where('kab', '7316')->where('kec', $kec)->where('status', 1)->count();

		}else{
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

			$pesertajummpm = PesertaMpm::raw(function($collection) {
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
			$rtjummpm = PesertaMpm::where('kab', '7316')->where('status', 1)->count();
		}
		
		// $baroko = PesertaBDT::getsummary('baroko', '7316053');
		// $malle = PesertaBDT::getsummary('malle', '7316052');
		// $alla = PesertaBDT::getsummary('alla', '7316050');
		// $curio = PesertaBDT::getsummary('curio', '7316051');
		// $angoraja = PesertaBDT::getsummary('angoraja', '7316040');
		// $malua = PesertaBDT::getsummary('malua', '7316041');
		// $baraka = PesertaBDT::getsummary('baraka', '7316030');
		// $enrekang = PesertaBDT::getsummary('enrekang', '7316020');
		// $buntubatu = PesertaBDT::getsummary('buntubatu', '7316031');
		// $bungin = PesertaBDT::getsummary('bungin', '7316011');
		// $cendana = PesertaBDT::getsummary('cendana', '7316021');
		// $maiwa = PesertaBDT::getsummary('maiwa', '7316010');

		// $data = array($baroko, $malle, $alla, $curio, $angoraja, $malua, $baraka, $enrekang, $buntubatu, $bungin, $cendana, $maiwa);
		// dd($data);
		return view('Dashboard::pages.dashboard.index', ['pesertajum' => $pesertajum, 'rtjum' => $rtjum, 'pesertajummpm'=>$pesertajummpm, 'rtjummpm' => $rtjummpm]);
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

	public function getSummmaryDetail()
	{
		$isKecamatan = isset($_GET['id']) ? $_GET['id'] : '';
		$idKelurahan = isset($_GET['kec']) ? $_GET['kec'] : '';
		
		
		$result = array(PesertaBDT::getSummaryDetail($isKecamatan, $idKelurahan));

		return json_encode(array(
			'message'	=> 'ok',
			'data'	=>json_encode($result)
		));
	}

	public function getDetailKategori()
	{
		$indikator = isset($_GET['indikator']) ? $_GET['indikator'] : false;
		$value = isset($_GET['value']) ? $_GET['value'] : false;
		$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : false;
		$idKelurahan = isset($_GET['kelurahan']) ? $_GET['kelurahan'] : false;
		$idBy = isset($_GET['by']) ? $_GET['by'] : false;
		$idSearch = isset($_GET['q']) ? $_GET['q'] : false;
		$getkecamatan = Kecamatan::where('id_kota', '7316')->where('status', true)->get();

		$kelurahan = Kelurahan::where('id_kelurahan', $idKelurahan)->where('status', true)->get();
		$kecamatan = Kecamatan::where('id_kecamatan', $kelurahan[0]['id_kecamatan'])->where('status', true)->first();
		if($idSearch){
			if($idBy){
				if($idBy == 'nourut'){
					$rt = PesertaBDT::where('kab', '7316')->where('des', $idKelurahan)->where('nourut_rt', $idSearch)->where('status', 1)->get();
					$rtmpm = PesertaMpm::where('kab', '7316')->where('des', $idKelurahan)->where('nourut_rt', $idSearch)->where('status', 1)->get();					
				}else if($idBy == 'namaruta'){
					$rt = PesertaBDT::where('kab', '7316')->where('des', $idKelurahan)->where('individu.nama', 'like', '%'.$idSearch.'%')->where('individu.b4_k3', '1')->where('status', 1)->get();
					$rtmpm = PesertaMpm::where('kab', '7316')->where('des', $idKelurahan)->where('individu.nama', 'like', '%'.$idSearch.'%')->where('individu.b4_k3', '1')->where('status', 1)->get();					
				}
			}else{
				$rt = PesertaBDT::where('kab', '7316')->where('des', $idKelurahan)->where('status', 1)->get();
				$rtmpm = PesertaMpm::where('kab', '7316')->where('des', $idKelurahan)->where('status', 1)->get();
			}
		}else{
			$rt = PesertaBDT::where('kab', '7316')->where('des', $idKelurahan)->where('status', 1)->get();
			$rtmpm = PesertaMpm::where('kab', '7316')->where('des', $idKelurahan)->where('status', 1)->get();
		}

		$listkel = [];
		
		$rt->merge($rtmpm);

		$processData = new PesertaBDT;
		$result = $processData->getPesertaValueOfIndicator($indikator, $value,$kategori, $rt);
		$resultCollection = collect($result);
		
		//dd($this->paginateMe($resultCollection, 50, $page = null, $options = []));
		
		return view('Dashboard::pages.dashboard.detail-map', [
			'peserta' => $this->paginateMe($resultCollection, 50, $page = null, $options = []),
			'kecamatan' => $getkecamatan,
			'jumpeserta' => count($result)
		]);
	}

	public function paginateMe($items, $perPage = 15, $page = null, $options = [])
	{
		$page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
		$items = $items instanceof Collection ? $items : Collection::make($items);
		return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
	}
}
