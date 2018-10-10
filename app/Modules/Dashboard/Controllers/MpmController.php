<?php

namespace App\Modules\Dashboard\Controllers;

use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\IndikatorVariabel;
use App\Models\IndividuVariabel;
use App\Models\RtVariabel;
use App\Models\AssetVariabel;
use App\Models\OpsiIndikator;
use App\Models\PesertaMpm;
use App\Models\PesertaIndividu;
use App\Models\PesertaPendaftar;
use App\Models\PesertaBDT;
use App\Models\PesertaPpfmrt;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MpmController extends Controller
{
	public function index(){
		$kecamatan = Kecamatan::where('id_kota', '7316')->where('status', '1')->get();
		/*$indivarindividu = IndikatorVariabel::where('tingkat', '1')->where('pendaftaran', '1')->where('status', 1)->get();*/
		$indivarrt = IndikatorVariabel::where('tingkat', '2')->where('pendaftaran', '1')->where('status', 1)->get();
		$indivarasset = IndikatorVariabel::where('tingkat', '3')->where('pendaftaran', '1')->where('status', 1)->get();
		return view('Dashboard::pages.mpm.registrasi', ['kecamatan' => $kecamatan,
														'indivarasset' => $indivarasset,
														'indivarrt' => $indivarrt,
														/*'indivarindividu' => $indivarindividu*/
														]);
	}

	public function listmpm(){
		$peserta_mpm = PesertaMpm::where('status', 1)->paginate(50);
		return view('Dashboard::pages.mpm.list-peserta', ['peserta' => $peserta_mpm]);
	}

	public function getpesertaterdaftar(){
		$nikkrt = empty($_GET['nikkrt']) ? "" : $_GET['nikkrt'];
		$kec = empty($_GET['kec']) ? "" : $_GET['kec'];
		$kel = empty($_GET['kel']) ? "" : $_GET['kel'];

		$getkrt = PesertaBDT::where('individu.nik', $nikkrt)->where('individu.spkt2', '1')->where('kecamatan', $kec)->where('kelurahan', $kel)->where('status', 1)->get();
		if($getkrt->isEmpty()){
			$getkrtmpm = PesertaMpm::where('individu.nik', $nikkrt)->where('individu.spkt2', '1')->where('kecamatan', $kec)->where('kelurahan', $kel)->where('status', 1)->get();
			 if($getkrtmpm->isEmpty()){
				$pesan = array('success' => 1, 'message' => 'belum terdaftar');
			}else{
				$pesan = array('success' => 0, 'message' => 'sudah terdaftar');
			}
		}else{
			$pesan = array('success' => 0, 'message' => 'sudah terdaftar');
		}

		return json_encode($pesan);
	}

	public function postregistrasi(Request $request){
		$getcountbdt = PesertaBDT::where('status', 1)->count();
		$getkrt = PesertaBDT::where('individu.nik',  $request->get('nikKepRt'))->where('individu.b4_k3', '1')->where('kec', $request->get('kecamatan'))->where('des', $request->get('kelurahan'))->where('status', 1)->get();
		$getkrtmpm = PesertaMpm::where('individu.nik',  $request->get('nikKepRt'))->where('individu.b4_k3', '1')->where('kec', $request->get('kecamatan'))->where('des', $request->get('kelurahan'))->where('status', 1)->get();

		$getkodempm = PesertaMpm::where('status', 1)->orderBy('_id', 'DESC')->get();
		if($getkodempm->isEmpty()){
			$kode = 'pspkt-'.$getcountbdt;
		}else{
			$getkode = substr($getkodempm[0]->kodepeserta, 6);
			$kode = 'pspkt-'.((int)$getkode + 1);
		}

		if($getkrt->isEmpty() && $getkrtmpm->isEmpty()){
			$peserta = new PesertaMpm;
			$peserta->prov = '73';
			$peserta->kota = '7316';
			$peserta->kec = $request->get('kecamatan');
			$peserta->des = $request->get('kelurahan');
			$peserta->b1_k6 = $request->get('namaJalan');
			$peserta->nourut_rt = '';
			$peserta->kodepeserta = $kode;
			$peserta->nokk = $request->get('nomorKk');
			$peserta->b1_k9 = $request->get('jumAngKel');
			$peserta->b1_k10 = '';
			$peserta->verifikasi = 0;            
			$peserta->statuskesejahteraan = '';
			$peserta->pendidikanart = $request->get('pendidikanart');
			$peserta->status = 1;
			$peserta->individu = array(
								array(
									'_id' => new \MongoDB\BSON\ObjectID(),
									'nourut_rt' => 1,
									'kodepeserta' => $kode,
									'nik' => $request->get('nikKepRt'),
									'nama' => $request->get('namaKepRt'),
									'b4_k6' => $request->get('jenisKelKepRt'),
									'b4_k3' => '1',
									'b4_k7' => $request->get('umur'),
									'statusbekerja' => $request->get('pekerjaanKepRt'),
									'status' => 1)
								);
			$peserta->asset = array(
							array_merge(array('_id' => new \MongoDB\BSON\ObjectID()), json_decode($request->get('assetVar'), true))
							);
			$peserta->datart = array(
							array_merge(array('_id' => new \MongoDB\BSON\ObjectID()), json_decode($request->get('rtVar'), true))
							);
			$peserta->pendaftar = array(
							array_merge(array('_id' => new \MongoDB\BSON\ObjectID()), json_decode($request->get('indiVar'), true), array('kodepeserta' => $kode, 'nik' => $request->get('nik'), 'nama' => $request->get('namaLengkap'), 'jenkel' => $request->get('jenisKelamin') ))
							);

			if($peserta->save()){
				$pesan = array('success' => 1, 'message' => 'Terima kasih. Rumah tangga berhasil terdaftar');
			}else{
				$pesan = array('success' => 0, 'message' => 'Mohon maaf. Rumah tangga gagal terdaftar');
			}
		}else{
			$pesan = array('success' => 0, 'message' => 'Mohon maaf. Rumah tangga telah terdaftar');
		}

		return json_encode($pesan);
	}

	public function getkota($idprov){
		$kota = Kota::where('id_provinsi', $idprov)->where('status', '1')->get();

		return json_encode($kota);
	}

	public function update($idpeserta){
		$peserta = PesertaMpm::where('_id', $idpeserta)->where('status', 1)->get();
		$kecamatan = Kecamatan::where('id_kota', '7316')->where('status', '1')->get();
		$kelurahan = Kelurahan::where('id_kecamatan', $peserta[0]->kec)->where('status', '1')->get();
		$indivarindividu = IndikatorVariabel::where('tingkat', '1')->where('pendaftaran', '1')->where('status', 1)->get();
		$indivarrt = IndikatorVariabel::where('tingkat', '2')->where('pendaftaran', '1')->where('status', 1)->get();
		$indivarasset = IndikatorVariabel::where('tingkat', '3')->where('pendaftaran', '1')->where('status', 1)->get();

		return view('Dashboard::pages.mpm.update-peserta', ['kecamatan' => $kecamatan,
														'kelurahan' => $kelurahan,
														'indivarrt' => $indivarrt,
														'indivarindividu' => $indivarindividu,
														'indivarasset' => $indivarasset,
														'peserta' => $peserta,
														]);
	}


	public function postupdate(Request $request){
		$getpesertampm = PesertaMpm::where('_id', $request->get('idpeserta'))->where('status', 1)->get();

		if($getpesertampm->isEmpty()){
			$pesan = array('success' => 0, 'message' => 'Mohon maaf. Rumah tangga tidak ditemukan');
		}else{

			$getkrtmpm = PesertaMpm::where('individu.nik', $request->get('nikKepRt'))->where('individu.b4_k3', '1')->where('kec', $request->get('kecamatan'))->where('des', $request->get('kelurahan'))->where('status', 1)->get();
			$getkrt = PesertaBDT::where('individu.nik', $request->get('nikKepRt'))->where('individu.b4_k3', '1')->where('kec', $request->get('kecamatan'))->where('des', $request->get('kelurahan'))->where('status', 1)->get();

			if($getkrt->isEmpty() && $getkrtmpm->isEmpty()){
				$peserta = PesertaMpm::where('_id', $request->get('idpeserta'))->where('status', 1)->first();
				$peserta->kec = $request->get('kecamatan');
				$peserta->des = $request->get('kelurahan');
				$peserta->b1_k6 = $request->get('namaJalan');
				$peserta->nokk = $request->get('nomorKk');
				$peserta->b1_k9 = $request->get('jumAngKel');

		        $individu = PesertaMpm::where('_id', $request->get('idpeserta'))->where('individu.b4_k3', '1')->
		        		update(array('individu.$.nik' => $request->get('nikKepRt'),
							'individu.$.nama' => $request->get('namaKepRt'),
							'individu.$.b4_k6' => $request->get('jenisKelKepRt'),
							'individu.$.b4_k7' => $request->get('umur'),
							'individu.$.statusbekerja' => $request->get('pekerjaanKepRt'),
    					));

		        $asset = PesertaMpm::where('_id', $request->get('idpeserta'))->
		        		update(json_decode($request->get('assetVar'), true));

		        $datart = PesertaMpm::where('_id', $request->get('idpeserta'))->
		        		update(json_decode($request->get('rtVar'), true));

		        $pendaftar = PesertaMpm::where('_id', $request->get('idpeserta'))->
		        		update(array_merge(json_decode($request->get('indiVar'), true), array('pendaftar.0.nik' => $request->get('nik'), 'pendaftar.0.nama' => $request->get('namaLengkap'), 'pendaftar.0.jenkel' => $request->get('jenisKelamin') )));
				if($peserta->save()){
					$pesan = array('success' => 1, 'message' => 'Terima kasih. Rumah tangga berhasil disunting');
				}else{
					$pesan = array('success' => 0, 'message' => 'Mohon maaf. Rumah tangga gagal disunting');
				}
			}else{
				if(($getkrtmpm[0]->_id == $request->get('idpeserta'))){
					$peserta = PesertaMpm::where('_id', $request->get('idpeserta'))->where('status', 1)->first();
					$peserta->kec = $request->get('kecamatan');
					$peserta->des = $request->get('kelurahan');
					$peserta->b1_k6 = $request->get('namaJalan');
					$peserta->nokk = $request->get('nomorKk');
					$peserta->b1_k9 = $request->get('jumAngKel');

					$umur = explode("/", $request->get('ttlKepRt'));

			        $individu = PesertaMpm::where('_id', $request->get('idpeserta'))->where('individu.b4_k3', '1')->
			        		update(array('individu.$.nik' => $request->get('nikKepRt'),
								'individu.$.nama' => $request->get('namaKepRt'),
								'individu.$.b4_k6' => $request->get('jenisKelKepRt'),
								'individu.$.b4_k7' => $request->get('umur'),
								'individu.$.statusbekerja' => $request->get('pekerjaanKepRt'),
	    					));

			        $asset = PesertaMpm::where('_id', $request->get('idpeserta'))->
			        		update(json_decode($request->get('assetVar'), true));

			        $datart = PesertaMpm::where('_id', $request->get('idpeserta'))->
			        		update(json_decode($request->get('rtVar'), true));

			        $pendaftar = PesertaMpm::where('_id', $request->get('idpeserta'))->
			        		update(array_merge(json_decode($request->get('indiVar'), true), array('pendaftar.0.nik' => $request->get('nik'), 'pendaftar.0.nama' => $request->get('namaLengkap'), 'pendaftar.0.jenkel' => $request->get('jenisKelamin') )));
					if($peserta->save()){
						$pesan = array('success' => 1, 'message' => 'Terima kasih. Rumah tangga berhasil disunting');
					}else{
						$pesan = array('success' => 0, 'message' => 'Mohon maaf. Rumah tangga gagal disunting');
					}
				}else{
					$pesan = array('success' => 0, 'message' => 'Mohon maaf. Rumah tangga sudah terdaftar');
				}
			}

		}

		return json_encode($pesan);
	}

	public function delete($idpeserta){
		$getpeserta = PesertaMpm::where('_id', $idpeserta)->where('status', 1)->get();
		if($getpeserta->isEmpty()){
			$pesan = array('success' => 0, 'message' => 'Rumah tangga peserta tidak ditemukan');
		}else{
			$peserta = PesertaMpm::where('_id', $idpeserta)->where('status', 1)->first();
			$peserta->status = 0;

			if($peserta->save()){
				$pesan = array('success' => 1, 'message' => 'Rumah tangga peserta MPM berhasil di hapus');
			}else{
				$pesan = array('success' => 0, 'message' => 'Rumah tangga peserta MPM gagal dihapus');
			}
		}

		return json_encode($pesan);
	}

	public function detail($idpeserta){
		$peserta = PesertaMpm::where('_id', $idpeserta)->where('status', 1)->get();
		if($peserta->isEmpty()){
			return redirect('/mpm');
		}else{
			return view('Dashboard::pages.mpm.detail-peserta', ['peserta' => $peserta,
																]);
		}
	}

	public function getkecamatan($idkota){
		$kecamatan = Kecamatan::where('id_kota', $idkota)->where('status', '1')->get();

		return json_encode($kecamatan);
	}

	public function getkelurahan($idkec){
		$kelurahan = Kelurahan::where('id_kecamatan', $idkec)->where('status', '1')->get();

		return json_encode($kelurahan);
	}
}
