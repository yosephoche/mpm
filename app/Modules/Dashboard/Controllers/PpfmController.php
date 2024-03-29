<?php

namespace App\Modules\Dashboard\Controllers;

use Illuminate\Http\Request;
use App\Models\PesertaMpm;
use App\Models\IndikatorVariabel;
use App\Models\OpsiIndikator;
use App\Models\PesertaTanggungan;
use App\Models\PesertaBDT;
use App\Models\RtVariabel;
use App\Models\AssetVariabel;
use App\Http\Requests;
use App\Models\Kelurahan;
use App\Models\Kecamatan;
use App\Models\AnggaranKegiatan;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
//use Jenssegers\Mongodb\Collection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PpfmController extends Controller
{
	public function newpeserta(){
		$kec = empty($_GET['kec']) ? '' : $_GET['kec'];
		$getkecamatan = Kecamatan::where('id_kota', '7316')->where('status', true)->get();

		if(empty($kec)){
			$peserta_mpm = PesertaMpm::where('status', 1)->paginate(50);		
			$peserta_count = PesertaMpm::where('status', 1)->count();		
		}else{
			$peserta_mpm = PesertaMpm::where('kec', $kec)->where('status', 1)->paginate(50);
			$peserta_count = PesertaMpm::where('kec', $kec)->where('status', 1)->count();
		}
		return view('Dashboard::pages.ppfm.list-new-peserta', ['peserta' => $peserta_mpm, 'kecamatan' => $getkecamatan, 'jumpeserta'=>$peserta_count]);
	}

	public function newverification($idpeserta){
		$indivarindividu = IndikatorVariabel::where('tingkat', '1')->where('verifikasi', '1')->whereNotIn('kode_variabel', ['nama', 'nik'])->where('status', 1)->get();
		$indivarrt = IndikatorVariabel::where('tingkat', '2')->where('verifikasi', '1')->whereNotIn('kode_variabel', ['b1_k6', 'b1_k9', 'b1_k10', 'b1_k8', 'statuskesejahteraan'])->where('status', 1)->get();
		$indivarasset = IndikatorVariabel::where('tingkat', '3')->whereNotIn('kode_variabel', ['nik', 'nama'])->where('verifikasi', '1')->where('status', 1)->get();
		$peserta_mpm = PesertaMpm::where('_id', $idpeserta)->where('status', 1)->get();
		return view('Dashboard::pages.ppfm.new-verifikasi',['peserta' => $peserta_mpm,
															'indivarasset' => $indivarasset,
															'indivarrt' => $indivarrt,
															'indivarindividu' => $indivarindividu
															]);
	}

	public function updateverification($idpeserta){
		$indivarindividu = IndikatorVariabel::where('tingkat', '1')->where('verifikasi', '1')->whereNotIn('kode_variabel', ['nama', 'nik'])->where('status', 1)->get();
		$indivarrt = IndikatorVariabel::where('tingkat', '2')->where('verifikasi', '1')->whereNotIn('kode_variabel', ['b1_k6', 'b1_k9', 'b1_k10', 'b1_k8', 'statuskesejahteraan'])->where('status', 1)->get();
		$indivarasset = IndikatorVariabel::where('tingkat', '3')->where('verifikasi', '1')->where('status', 1)->get();
		$peserta_bdt = PesertaBDT::where('_id', $idpeserta)->where('status', 1)->get();
		return view('Dashboard::pages.ppfm.old-update',['peserta' => $peserta_bdt,
															'indivarasset' => $indivarasset,
															'indivarrt' => $indivarrt,
															'indivarindividu' => $indivarindividu
															]);
	}

	public function oldpeserta(){
		$kec = empty($_GET['kec']) ? '' : $_GET['kec'];
		$getkecamatan = Kecamatan::where('id_kota', '7316')->where('status', true)->get();

		if(empty($kec)){
			$peserta_bdt = PesertaBDT::where('status', 1)->orderBy('_id', 'ASC')->paginate(50);
			$peserta_count = PesertaBDT::where('status', 1)->orderBy('_id', 'ASC')->count();
		}else{
			$peserta_bdt = PesertaBDT::where('status', 1)->where('kec', $kec)->orderBy('_id', 'ASC')->paginate(50);
			$peserta_count = PesertaBDT::where('status', 1)->where('kec', $kec)->orderBy('_id', 'ASC')->count();
		}
		
		return view('Dashboard::pages.ppfm.list-old-peserta', ['peserta' => $peserta_bdt, 'kecamatan' => $getkecamatan, 'jumpeserta' => $peserta_count]);
	}

	public function postoldpeserta(Request $request){
		$getpeserta = PesertaBDT::where('_id', $request->get('id'))->where('status', 1)->get();
		if($getpeserta->isEmpty()){
			$pesan = array('success'=> 0, 'message'=> 'Peserta tidak ditemukan');
		}else{

			$peserta = PesertaBDT::where('_id', $request->get('id'))->where('status', 1)->first();
			$peserta->nokk = $request->get('nokk');
			$peserta->sls = $request->get('sls');
			$peserta->b1_k10 = $request->get('jum_kel');

			$asset = PesertaBDT::where('_id', $request->get('id'))->
	        		update(json_decode($request->get('assetVar'), true));

	        $datart = PesertaBDT::where('_id', $request->get('id'))->
	        		update(json_decode($request->get('rtVar'), true));

			if($peserta->save()){
				$pesan = array('success' => 1, 'message' => 'Terima kasih. Rumah tangga berhasil disunting');
			}else{
				$pesan = array('success' => 0, 'message' => 'Mohon maaf. Rumah tangga gagal disunting');
			}
		}
		return json_encode($pesan);
	}

	public function postnewverification(Request $request){
		$getpeserta = PesertaMpm::where('_id', $request->get('id'))->where('status', 1)->get();
		if($getpeserta->isEmpty()){
			$pesan = array('success'=> 0, 'message'=> 'Peserta tidak ditemukan');
		}else{

			$peserta = PesertaMpm::where('_id', $request->get('id'))->where('status', 1)->first();
			$peserta->nokk = $request->get('nokk');
			$peserta->sls = $request->get('sls');
			$peserta->b1_k10 = $request->get('jum_kel');
			$peserta->verifikasi = 1;

	        $asset = PesertaMpm::where('_id', $request->get('id'))->
	        		update(json_decode($request->get('assetVar'), true));

	        $datart = PesertaMpm::where('_id', $request->get('id'))->
	        		update(json_decode($request->get('rtVar'), true));

			if($peserta->save()){
				$pesan = array('success' => 1, 'message' => 'Terima kasih. Rumah tangga berhasil disunting');
			}else{
				$pesan = array('success' => 0, 'message' => 'Mohon maaf. Rumah tangga gagal disunting');
			}
		}
		return json_encode($pesan);
	}

	public function postregistrasiindividu(Request $request){
		$no = 1;
		$getpeserta = PesertaBDT::where('kodepeserta', $request->get('kodepeserta'))->where('individu', 'elemMatch', ['nik' => $request->get('nik') ,'status' => 1])->get();
		if(!$getpeserta->isEmpty()){
			$pesan = array('success' => 0, 'message' => 'Anggota rumah tangga telah terdaftar');
		}else{
			$idMongo = new \MongoDB\BSON\ObjectID();
			$peserta = PesertaBDT::where('kodepeserta', $request->get('kodepeserta'))->where('status', 1)->push(array('individu' => array_merge(array('_id' => $idMongo, 'nik' => $request->get('nik'), 'nama' => $request->get('nama'), 'statuskesejahteraan' => '', 'status' => 1), json_decode($request->get('indiVar'), true)) ));

			if($peserta){

				$getcountpeserta = PesertaBDT::raw(function($collection) use($request){
					return $collection->aggregate(array(
						array( '$unwind' => '$individu'
						),
						array( '$match' => array(
							'kodepeserta' => $request->get('kodepeserta'),
							'individu.status' => 1
						))
					));
				});

				for ($i=0; $i < count($getcountpeserta); $i++) { 
					$individu = PesertaBDT::where('kodepeserta', $getcountpeserta[$i]->kodepeserta)->where('individu', 'elemMatch', ['nik' => $getcountpeserta[$i]->individu['nik'],'status' => 1])->
				        		update(array('individu.$.no_art' => $no++,
		    					));
				}

				$updpesertampm = PesertaBDT::where('kodepeserta', $request->get('kodepeserta'))->where('status', 1)->update([
					'b1_k9' => count($getcountpeserta)
					]);
				$pesan = array('success'=>1, 'message' => 'Pendaftaran anggota berhasil tersimpan', 'id' => $idMongo);
			}else{
				$pesan = array('success'=>0, 'message' => 'Pendaftaran anggota gagal tersimpan');
			}

		}

		return json_encode($pesan);
	}

	public function postregverifindividu(Request $request){
		$no = 1;

		$getpeserta = PesertaMpm::where('kodepeserta', $request->get('kodepeserta'))->where('individu', 'elemMatch', ['nik' => $request->get('nik') ,'status' => 1])->get();
		if(!$getpeserta->isEmpty()){
			$pesan = array('success' => 0, 'message' => 'Anggota rumah tangga telah terdaftar');
		}else{
			$idMongo = new \MongoDB\BSON\ObjectID();
			$peserta = PesertaMpm::where('kodepeserta', $request->get('kodepeserta'))->where('status', 1)->push(array('individu' => array_merge(array('_id' => $idMongo, 'nik' => $request->get('nik'), 'nama' => $request->get('nama'), 'statuskesejahteraan' => '', 'status' => 1), json_decode($request->get('indiVar'), true)) ));

			if($peserta){

				$getcountpeserta = PesertaMpm::raw(function($collection) use($request){
					return $collection->aggregate(array(
						array( '$unwind' => '$individu'
						),
						array( '$match' => array(
							'kodepeserta' => $request->get('kodepeserta'),
							'individu.status' => 1
						))
					));
				});

				for ($i=0; $i < count($getcountpeserta); $i++) { 
					$individu = PesertaMpm::where('kodepeserta', $getcountpeserta[$i]->kodepeserta)->where('individu', 'elemMatch', ['nik' => $getcountpeserta[$i]->individu['nik'],'status' => 1])->
				        		update(array('individu.$.no_art' => $no++,
		    					));
				}

				$updpesertampm = PesertaMpm::where('kodepeserta', $request->get('kodepeserta'))->where('status', 1)->update([
					'b1_k9' => count($getcountpeserta)
					]);
				$pesan = array('success'=>1, 'message' => 'Pendaftaran anggota berhasil tersimpan', 'id'=>$idMongo);
			}else{
				$pesan = array('success'=>0, 'message' => 'Pendaftaran anggota gagal tersimpan');
			}

		}

		return json_encode($pesan);
	}

	public function delpesertaindividu(){
		$kodepeserta = empty($_GET['kode']) ? '' : $_GET['kode'];
		$idpeserta = empty($_GET['id']) ? '' : $_GET['id'];
		$no = 1;

		$getpeserta = PesertaBDT::where('kodepeserta', $kodepeserta)->where('individu', 'elemMatch', ['_id' => new \MongoDB\BSON\ObjectID($idpeserta),'status' => 1])->get();
		if($getpeserta->isEmpty()){
			$pesan = array('success'=>0, 'message'=>'Peserta tidak ditemukan');
		}else{
			$updpeserta = PesertaBDT::where('kodepeserta', $kodepeserta)->where('individu', 'elemMatch', ['_id' => new \MongoDB\BSON\ObjectID($idpeserta), 'status' => 1])->
        		update(array('individu.$.status' => 0,
				));

			if($updpeserta){
				$getcountpeserta = PesertaBDT::raw(function($collection) use($kodepeserta){
					return $collection->aggregate(array(
						array( '$unwind' => '$individu'
						),
						array( '$match' => array(
							'kodepeserta' => $kodepeserta,
							'individu.status' => 1
						))
					));
				});

				for ($i=0; $i < count($getcountpeserta); $i++) { 
					$individu = PesertaBDT::where('kodepeserta', $getcountpeserta[$i]->kodepeserta)->where('individu', 'elemMatch', ['_id' => new \MongoDB\BSON\ObjectID($getcountpeserta[$i]->individu['_id']),'status' => 1])->
				        		update(array('individu.$.no_art' => $no++,
		    					));
				}

				$updpesertabdt = PesertaBDT::where('kodepeserta', $kodepeserta)->where('status', 1)->update([
					'jumart' => count($getcountpeserta)
					]);
				$pesan = array('success'=>1, 'message'=>'Peserta berhasil dihapus');
			}else{
				$pesan = array('success'=>0, 'message'=>'Peserta gagal dihapus');
			}

		}

		return json_encode($pesan);
	}

	public function delpesertaverifindividu(){
		$kodepeserta = empty($_GET['kode']) ? '' : $_GET['kode'];
		$idpeserta = empty($_GET['id']) ? '' : $_GET['id'];
		$no = 1;

		$getpeserta = PesertaMpm::where('kodepeserta', $kodepeserta)->where('individu', 'elemMatch', ['_id' => new \MongoDB\BSON\ObjectID($idpeserta),'status' => 1])->get();
		if($getpeserta->isEmpty()){
			$pesan = array('success'=>0, 'message'=>'Peserta tidak ditemukan');
		}else{
			$cantdel = PesertaMpm::where('kodepeserta', $kodepeserta)->where('individu', 'elemMatch', ['_id' => new \MongoDB\BSON\ObjectID($idpeserta), 'b4_k3' => '1', 'status' => 1])->get();
			if($cantdel->isEmpty()){
			$updpeserta = PesertaMpm::where('kodepeserta', $kodepeserta)->where('individu', 'elemMatch', ['_id' => new \MongoDB\BSON\ObjectID($idpeserta), 'status' => 1])->
        		update(array('individu.$.status' => 0,
				));

				if($updpeserta){
					$getcountpeserta = PesertaMpm::raw(function($collection) use($kodepeserta){
						return $collection->aggregate(array(
							array( '$unwind' => '$individu'
							),
							array( '$match' => array(
								'kodepeserta' => $kodepeserta,
								'individu.status' => 1
							))
						));
					});

					for ($i=0; $i < count($getcountpeserta); $i++) { 
						$individu = PesertaBDT::where('kodepeserta', $getcountpeserta[$i]->kodepeserta)->where('individu', 'elemMatch', ['_id' => new \MongoDB\BSON\ObjectID($getcountpeserta[$i]->individu['_id']),'status' => 1])->
									update(array('individu.$.no_art' => $no++,
									));
					}
					$updpesertabdt = PesertaMpm::where('kodepeserta', $kodepeserta)->where('status', 1)->update([
						'jumart' => count($getcountpeserta)
						]);
					$pesan = array('success'=>1, 'message'=>'Peserta berhasil dihapus');
				}else{
					$pesan = array('success'=>0, 'message'=>'Peserta gagal dihapus');
				}
			}else{
				$pesan = array('success'=>0, 'message'=>'Peserta gagal dihapus');
			}

		}

		return json_encode($pesan);
	}

	public function postupdateindividu(Request $request){
		$no = 1;
		$getpeserta = PesertaBDT::where('status', 1)->where('kodepeserta', $request->get('kodepeserta'))->where('individu', 'elemMatch', ['_id' => new \MongoDB\BSON\ObjectID($request->get('idp')),'status' => 1])->get();
		if($getpeserta->isEmpty()){
			$pesan = array('success' => 0, 'message' => 'Anggota rumah tangga tidak ditemukan');
		}else{
			$peserta_nik = PesertaBDT::raw(function($collection) use($request) {
				return $collection->aggregate(array(
					array( '$unwind' => '$individu'
					),
					array( '$match' => array(
						'kodepeserta' => $request->get('kodepeserta'),
						'individu.nik' => $request->get('nik'),
						'individu.status' => 1
					))
				));
			});
			if($peserta_nik[0]->individu['_id'] == new \MongoDB\BSON\ObjectID($request->get('idp'))){

				try {
					$peserta = PesertaBDT::where('status', 1)->where('kodepeserta', $request->get('kodepeserta'))->where('individu', 'elemMatch', ['_id' => new \MongoDB\BSON\ObjectID($request->get('idp')),'status' => 1])->update(
						array_merge(json_decode($request->get('indiVar'), true), array('individu.'.$request->get('index').'.nama' => $request->get('nama'), 'individu.'.$request->get('index').'.nik' => $request->get('nik') ))
					);
					if($peserta){
						$getcountpeserta = PesertaBDT::raw(function($collection) use($request){
							return $collection->aggregate(array(
								array( '$unwind' => '$individu'
								),
								array( '$match' => array(
									'kodepeserta' => $request->get('kodepeserta'),
									'individu.status' => 1
								))
							));
						});
	
						for ($i=0; $i < count($getcountpeserta); $i++) { 
							$individu = PesertaBDT::where('kodepeserta', $getcountpeserta[$i]->kodepeserta)->where('individu', 'elemMatch', ['_id' => new \MongoDB\BSON\ObjectID($getcountpeserta[$i]->individu['_id']),'status' => 1])->
										update(array('individu.$.no_art' => $no++,
										));
						}
	
						$updpesertampm = PesertaBDT::where('kodepeserta', $request->get('kodepeserta'))->where('status', 1)->update([
							'b1_k9' => count($getcountpeserta)
							]);
						$pesan = array('success'=>1, 'message' => 'Data anggota rumah tangga berhasil tersimpan');
					}else{
						$pesan = array('success'=>0, 'message' => 'Tidak Ada data yang berubah');
					}
				}catch (\Exception $e) {
					return $e->getMessage();
				}
			}else{
				$pesan = array('success'=>0, 'message' => 'NIK sudah digunakan');
			}
			

		}

		return json_encode($pesan);
	}

	public function postupdateverifindividu(Request $request){
		$no = 1;

		$getpeserta = PesertaMpm::where('status', 1)->where('kodepeserta', $request->get('kodepeserta'))->where('individu', 'elemMatch', ['_id' => new \MongoDB\BSON\ObjectID($request->get('idp')),'status' => 1])->get();
		if($getpeserta->isEmpty()){
			$pesan = array('success' => 0, 'message' => 'Anggota rumah tangga tidak ditemukan');
		}else{

			$peserta_nik = PesertaMpm::raw(function($collection) use($request) {
				return $collection->aggregate(array(
					array( '$unwind' => '$individu'
					),
					array( '$match' => array(
						'kodepeserta' => $request->get('kodepeserta'),
						'individu.nik' => $request->get('nik'),
						'individu.status' => 1
					))
				));
			});
			if($peserta_nik[0]->individu['_id'] == new \MongoDB\BSON\ObjectID($request->get('idp'))){

				try {
					$peserta = PesertaMpm::where('status', 1)->where('kodepeserta', $request->get('kodepeserta'))->where('individu', 'elemMatch', ['_id' => new \MongoDB\BSON\ObjectID($request->get('idp')),'status' => 1])->update(
							array_merge(json_decode($request->get('indiVar'), true), array('individu.'.$request->get('index').'.nama' => $request->get('nama'), 'individu.'.$request->get('index').'.nik' => $request->get('nik') ))
						);
		
					if($peserta){
						$getcountpeserta = PesertaMpm::raw(function($collection) use($request){
							return $collection->aggregate(array(
								array( '$unwind' => '$individu'
								),
								array( '$match' => array(
									'kodepeserta' => $request->get('kodepeserta'),
									'individu.status' => 1
								))
							));
						});
		
						for ($i=0; $i < count($getcountpeserta); $i++) { 
							$individu = PesertaMpm::where('kodepeserta', $getcountpeserta[$i]->kodepeserta)->where('individu', 'elemMatch', ['_id' => new \MongoDB\BSON\ObjectID($getcountpeserta[$i]->individu['_id']),'status' => 1])->
										update(array('individu.$.no_art' => $no++,
										));
						}
		
						$updpesertampm = PesertaMpm::where('kodepeserta', $request->get('kodepeserta'))->where('status', 1)->update([
							'b1_k9' => count($getcountpeserta)
							]);
						$pesan = array('success'=>1, 'message' => 'Data anggota rumah tangga berhasil tersimpan');
					}else{
						$pesan = array('success'=>0, 'message' => 'Tidak Ada Data yang diubah');
					}
				}catch (\Exception $e) {
					return $e->getMessage();
				}
			}else{
				$pesan = array('success'=>0, 'message' => 'NIK sudah digunakan');

			}

		}

		return json_encode($pesan);
	}

	public function postnewindividutanggungan(Request $request){
		$no = 1;

		$getpesertampm = PesertaMpm::where('kodepeserta', $request->get('kodepeserta'))->where('tanggungan', 'elemMatch', ['nik' => $request->get('nik'),'status' => 1])->get();

		if($getpesertampm->isEmpty()){
			$peserta = PesertaMpm::where('kodepeserta', $request->get('kodepeserta'))->where('status', 1)->push([
				'tanggungan' => [
					'_id'		=> new \MongoDB\BSON\ObjectID(),
					'kodepeserta' => $request->get('kodepeserta'),
					'nourut_tanggungan' => 0,
					'nik' => $request->get('nik'),
					'nama' => $request->get('nama'),
					'alamat' => $request->get('alamat'),
					'namasekolah' => $request->get('namasekolah'),
					'nisn' => $request->get('nisn'),
					'status' => 1
				]
			]);

			if($peserta){

				$getcountpeserta = PesertaMpm::raw(function($collection) use($request){
					return $collection->aggregate(array(
						array( '$unwind' => '$tanggungan'
						),
						array( '$match' => array(
							'kodepeserta' => $request->get('kodepeserta'),
							'tanggungan.status' => 1
						))
					));
				});

				for ($i=0; $i < count($getcountpeserta); $i++) { 
					$individu = PesertaMpm::where('kodepeserta', $getcountpeserta[$i]->kodepeserta)->where('tanggungan', 'elemMatch', ['nik' => $getcountpeserta[$i]->tanggungan['nik'],'status' => 1])->
				        		update(array('tanggungan.$.nourut_tanggungan' => $no++,
		    					));
				}

				$pesan = array('success'=>1, 'message' => 'Pendaftaran anggota berhasil tersimpan');
			}else{
				$pesan = array('success'=>0, 'message' => 'Pendaftaran anggota gagal tersimpan');
			}
		}else{
			$pesan = array('success' => 0, 'message' => 'Anggota rumah tangga telah terdaftar');
		}

		return json_encode($pesan);
	}

	public function postindividutanggungan(Request $request){
		$no = 1;

		$getpesertampm = PesertaBDT::where('kodepeserta', $request->get('kodepeserta'))->where('tanggungan', 'elemMatch', ['nik' => $request->get('nik'),'status' => 1])->get();

		if($getpesertampm->isEmpty()){
			$peserta = PesertaBDT::where('kodepeserta', $request->get('kodepeserta'))->where('status', 1)->push([
				'tanggungan' => [
					'_id'		=> new \MongoDB\BSON\ObjectID(),
					'kodepeserta' => $request->get('kodepeserta'),
					'nourut_tanggungan' => 0,
					'nik' => $request->get('nik'),
					'nama' => $request->get('nama'),
					'alamat' => $request->get('alamat'),
					'namasekolah' => $request->get('namasekolah'),
					'nisn' => $request->get('nisn'),
					'status' => 1
				]
			]);

			if($peserta){

				$getcountpeserta = PesertaBDT::raw(function($collection) use($request){
					return $collection->aggregate(array(
						array( '$unwind' => '$tanggungan'
						),
						array( '$match' => array(
							'kodepeserta' => $request->get('kodepeserta'),
							'tanggungan.status' => 1
						))
					));
				});

				for ($i=0; $i < count($getcountpeserta); $i++) { 
					$individu = PesertaBDT::where('kodepeserta', $getcountpeserta[$i]->kodepeserta)->where('tanggungan', 'elemMatch', ['nik' => $getcountpeserta[$i]->tanggungan['nik'],'status' => 1])->
				        		update(array('tanggungan.$.nourut_tanggungan' => $no++,
		    					));
				}

				$pesan = array('success'=>1, 'message' => 'Pendaftaran anggota berhasil tersimpan');
			}else{
				$pesan = array('success'=>0, 'message' => 'Pendaftaran anggota gagal tersimpan');
			}
		}else{
			$pesan = array('success' => 0, 'message' => 'Anggota rumah tangga telah terdaftar');
		}

		return json_encode($pesan);
	}

	public function delnewpesertatanggungan(){
		$kodepeserta = empty($_GET['kode']) ? '' : $_GET['kode'];
		$nikpeserta = empty($_GET['nik']) ? '' : $_GET['nik'];
		$no = 1;
		$getpeserta = PesertaMpm::where('kodepeserta', $kodepeserta)->where('tanggungan', 'elemMatch', ['nik' => $nikpeserta,'status' => 1])->get();
		if($getpeserta->isEmpty()){
			$pesan = array('success'=>0, 'message'=>'Peserta tidak ditemukan');
		}else{
			$updpeserta = PesertaMpm::where('kodepeserta', $kodepeserta)->where('tanggungan', 'elemMatch', ['nik' => $nikpeserta,'status' => 1])->
					update(array('tanggungan.$.status' => 0,
				));

			if($updpeserta){
				$getcountpeserta = PesertaMpm::raw(function($collection) use($kodepeserta){
					return $collection->aggregate(array(
						array( '$unwind' => '$tanggungan'
						),
						array( '$match' => array(
							'kodepeserta' => $kodepeserta,
							'tanggungan.status' => 1
						))
					));
				});

				for ($i=0; $i < count($getcountpeserta); $i++) { 
					$individu = PesertaMpm::where('kodepeserta', $getcountpeserta[$i]->kodepeserta)->where('tanggungan', 'elemMatch', ['nik' => $getcountpeserta[$i]->tanggungan['nik'],'status' => 1])->
				        		update(array('tanggungan.$.nourut_tanggungan' => $no++,
		    					));
				}
				$pesan = array('success'=>1, 'message'=>'Peserta berhasil dihapus');
			}else{
				$pesan = array('success'=>0, 'message'=>'Peserta gagal dihapus');
			}

		}

		return json_encode($pesan);
	}

	public function delpesertatanggungan(){
		$kodepeserta = empty($_GET['kode']) ? '' : $_GET['kode'];
		$nikpeserta = empty($_GET['nik']) ? '' : $_GET['nik'];
		$no = 1;
		$getpeserta = PesertaBDT::where('kodepeserta', $kodepeserta)->where('tanggungan', 'elemMatch', ['nik' => $nikpeserta,'status' => 1])->get();
		if($getpeserta->isEmpty()){
			$pesan = array('success'=>0, 'message'=>'Peserta tidak ditemukan');
		}else{
			$updpeserta = PesertaBDT::where('kodepeserta', $kodepeserta)->where('tanggungan', 'elemMatch', ['nik' => $nikpeserta,'status' => 1])->
					update(array('tanggungan.$.status' => 0,
				));

			if($updpeserta){
				$getcountpeserta = PesertaBDT::raw(function($collection) use($kodepeserta){
					return $collection->aggregate(array(
						array( '$unwind' => '$tanggungan'
						),
						array( '$match' => array(
							'kodepeserta' => $kodepeserta,
							'tanggungan.status' => 1
						))
					));
				});

				for ($i=0; $i < count($getcountpeserta); $i++) { 
					$individu = PesertaBDT::where('kodepeserta', $getcountpeserta[$i]->kodepeserta)->where('tanggungan', 'elemMatch', ['nik' => $getcountpeserta[$i]->tanggungan['nik'],'status' => 1])->
				        		update(array('tanggungan.$.nourut_tanggungan' => $no++,
		    					));
				}
				$pesan = array('success'=>1, 'message'=>'Peserta berhasil dihapus');
			}else{
				$pesan = array('success'=>0, 'message'=>'Peserta gagal dihapus');
			}

		}

		return json_encode($pesan);
	}

	public function postnewupdatetanggungan(Request $request){
		$no = 1;
		$getpeserta = PesertaMpm::where('kodepeserta', $request->get('kodepeserta'))->where('tanggungan', 'elemMatch', ['nik' => $request->get('nik'),'status' => 1])->get();
		if($getpeserta->isEmpty()){
			$pesan = array('success' => 0, 'message' => 'Anggota rumah tangga tidak ditemukan');
		}else{
			$peserta = PesertaMpm::where('kodepeserta', $request->get('kodepeserta'))->where('tanggungan', 'elemMatch', ['nik' => $request->get('nik'),'status' => 1])->
					update(array(
						'tanggungan.$.kodepeserta' => $request->get('kodepeserta'),
						'tanggungan.$.nama' => $request->get('nama'),
						'tanggungan.$.alamat' => $request->get('alamat'),
						'tanggungan.$.namasekolah' => $request->get('namasekolah'),
						'tanggungan.$.nisn' => $request->get('nisn')
				));

			if($peserta){
				
				$getcountpeserta = PesertaMpm::raw(function($collection) use($request){
					return $collection->aggregate(array(
						array( '$unwind' => '$tanggungan'
						),
						array( '$match' => array(
							'kodepeserta' => $request->get('kodepeserta'),
							'tanggungan.status' => 1
						))
					));
				});

				for ($i=0; $i < count($getcountpeserta); $i++) { 
					$individu = PesertaMpm::where('kodepeserta', $getcountpeserta[$i]->kodepeserta)->where('tanggungan', 'elemMatch', ['nik' => $getcountpeserta[$i]->tanggungan['nik'],'status' => 1])->
				        		update(array('tanggungan.$.nourut_tanggungan' => $no++,
		    					));
				}
				$pesan = array('success'=>1, 'message' => 'Data anggota rumah tangga berhasil tersimpan');
			}else{
				$pesan = array('success'=>0, 'message' => 'Data anggota rumah tangga gagal tersimpan');
			}

		}

		return json_encode($pesan);
	}


	public function postupdatetanggungan(Request $request){
		$no = 1;
		$getpeserta = PesertaBDT::where('kodepeserta', $request->get('kodepeserta'))->where('tanggungan', 'elemMatch', ['nik' => $request->get('nik'),'status' => 1])->get();
		if($getpeserta->isEmpty()){
			$pesan = array('success' => 0, 'message' => 'Anggota rumah tangga tidak ditemukan');
		}else{
			$peserta = PesertaBDT::where('kodepeserta', $request->get('kodepeserta'))->where('tanggungan', 'elemMatch', ['nik' => $request->get('nik'),'status' => 1])->
					update(array(
						'tanggungan.$.kodepeserta' => $request->get('kodepeserta'),
						'tanggungan.$.nama' => $request->get('nama'),
						'tanggungan.$.alamat' => $request->get('alamat'),
						'tanggungan.$.namasekolah' => $request->get('namasekolah'),
						'tanggungan.$.nisn' => $request->get('nisn')
				));

			if($peserta){
				
				$getcountpeserta = PesertaBDT::raw(function($collection) use($request){
					return $collection->aggregate(array(
						array( '$unwind' => '$tanggungan'
						),
						array( '$match' => array(
							'kodepeserta' => $request->get('kodepeserta'),
							'tanggungan.status' => 1
						))
					));
				});

				for ($i=0; $i < count($getcountpeserta); $i++) { 
					$individu = PesertaBDT::where('kodepeserta', $getcountpeserta[$i]->kodepeserta)->where('tanggungan', 'elemMatch', ['nik' => $getcountpeserta[$i]->tanggungan['nik'],'status' => 1])->
				        		update(array('tanggungan.$.nourut_tanggungan' => $no++,
		    					));
				}
				$pesan = array('success'=>1, 'message' => 'Data anggota rumah tangga berhasil tersimpan');
			}else{
				$pesan = array('success'=>0, 'message' => 'Data anggota rumah tangga gagal tersimpan');
			}

		}

		return json_encode($pesan);
	}

	public function deloldpeserta($idpeserta){
		$getpeserta = PesertaBDT::where('_id', $idpeserta)->where('status', 1)->get();
		if($getpeserta->isEmpty()){
			$pesan = array('success' => 0, 'message' => 'Rumah tangga peserta tidak ditemukan');
		}else{
			$peserta = PesertaBDT::where('_id', $idpeserta)->where('status', 1)->update([
				'status' => 0
			]);

			if($peserta){
				$pesan = array('success' => 1, 'message' => 'Rumah tangga peserta PPFM berhasil di hapus');
			}else{
				$pesan = array('success' => 0, 'message' => 'Rumah tangga peserta PPFM gagal dihapus');
			}
		}

		return json_encode($pesan);
	}

	public function delnewpeserta($idpeserta){
		$getpeserta = PesertaMpm::where('_id', $idpeserta)->where('status', 1)->get();
		if($getpeserta->isEmpty()){
			$pesan = array('success' => 0, 'message' => 'Rumah tangga peserta tidak ditemukan');
		}else{
			$peserta = PesertaMpm::where('_id', $idpeserta)->where('status', 1)->update([
				'status' => 0
			]);

			if($peserta){
				$pesan = array('success' => 1, 'message' => 'Rumah tangga peserta PPFM berhasil di hapus');
			}else{
				$pesan = array('success' => 0, 'message' => 'Rumah tangga peserta PPFM gagal dihapus');
			}
		}

		return json_encode($pesan);
	}

	public function cetakpesertabaru(){
		$kec = empty($_GET['kec']) ? '' : $_GET['kec'];
		$getkecamatan = Kecamatan::where('id_kota', '7316')->where('status', true)->get();

		if(empty($kec)){
			$peserta_mpm = PesertaMpm::where('status', 1)->paginate(50);		
		}else{
			$peserta_mpm = PesertaMpm::where('kec', $kec)->where('status', 1)->paginate(50);
		}
		return view('Dashboard::pages.ppfm.printout-belum', ['peserta'=>$peserta_mpm]);
	}

	public function cetakpesertalama(){
		$kec = empty($_GET['kec']) ? '' : $_GET['kec'];
		$getkecamatan = Kecamatan::where('id_kota', '7316')->where('status', true)->get();

		if(empty($kec)){
			$peserta_bdt = PesertaBDT::where('status', 1)->orderBy('_id', 'ASC')->paginate(50);
		}else{
			$peserta_bdt = PesertaBDT::where('status', 1)->where('kec', $kec)->orderBy('_id', 'ASC')->paginate(50);
		}

		return view('Dashboard::pages.ppfm.printout-sudah', ['peserta'=>$peserta_bdt]);
	}

	public function cetakpesertaindikator(){

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

		return view('Dashboard::pages.ppfm.printout-sudah', ['peserta'=>$this->paginateMe($resultCollection, 50, $page = null, $options = [])]);
	}

	public function cetakpesertaanggaran($idAnggaran){

		$anggaran = AnggaranKegiatan::where('_id', $idAnggaran)->where('status', 1)->first();

		$idBy = isset($_GET['by']) ? $_GET['by'] : false;
		$idSearch = isset($_GET['q']) ? $_GET['q'] : false;

		if($idSearch){
			if($idBy){
				if($idBy == 'nourut'){
					$rt = PesertaBDT::where('kab', '7316')->where('nourut_rt', $idSearch)->where('status', 1)->get();
					$rtmpm = PesertaMpm::where('kab', '7316')->where('nourut_rt', $idSearch)->where('status', 1)->get();					
				}else if($idBy == 'namaruta'){
					$rt = PesertaBDT::where('kab', '7316')->where('individu.nama', 'like', '%'.$idSearch.'%')->where('individu.b4_k3', '1')->where('status', 1)->get();
					$rtmpm = PesertaMpm::where('kab', '7316')->where('individu.nama', 'like', '%'.$idSearch.'%')->where('individu.b4_k3', '1')->where('status', 1)->get();					
				}
			}else{
				$rt = PesertaBDT::where('kab', '7316')->where('status', 1)->get();
				$rtmpm = PesertaMpm::where('kab', '7316')->where('status', 1)->get();
			}
		}else{
			$rt = PesertaBDT::where('kab', '7316')->where('status', 1)->get();
			$rtmpm = PesertaMpm::where('kab', '7316')->where('status', 1)->get();
		}

		$listkel = [];
		
		$rt->merge($rtmpm);

		$res = [];
		foreach($anggaran->indi_kategori as $listAngg){
			if(!is_null($listAngg)){
				/* for($i=0; $i<=2; $i++){ */
					$processData = new PesertaBDT;
					$result = $processData->getPesertaValueOfIndicator($listAngg, 0, 0, $rt);
					$res = array_unique(array_merge($res,$result), SORT_REGULAR);
				/* } */
			}
		}
		$resultCollection = collect($res);

		return view('Dashboard::pages.ppfm.printout-sudah', ['peserta'=>$this->paginateMe($resultCollection, 50, $page = null, $options = [])]);
	}
	public function paginateMe($items, $perPage = 15, $page = null, $options = [])
	{
		$page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
		$items = $items instanceof Collection ? $items : Collection::make($items);
		return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
	}
}
