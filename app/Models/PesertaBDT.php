<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\Helpers\IndikatorCount;

class PesertaBDT extends Eloquent
{
	protected $collection = 'peserta_bdt';
	public $timestamps = false;

	public static function getcountart($kode){
		$getcart = PesertaBDT::raw(function($collection) use($kode) {
			return $collection->aggregate(array(
				array( '$unwind' => '$individu'
				),
				array( '$match' => array(
					'individu.kodepeserta' => $kode,
					'individu.status' => 1
				)),
				array(
					'$count' => 'count'
				)
			));
		});

		
		return ($getcart->isEmpty()) ? '0' : $getcart[0]->count;
	}

	public static function getcountpeserta(){
		$getcount = PesertaBDT::where('status', 1)->count();

		return $getcount;
	}

    public static function getkrt($kodepeserta){
    	$getkrt = PesertaBDT::where('kodepeserta', $kodepeserta)->where('individu.b4_k3', '1')->first();
		if($getkrt){
    		$krt = $getkrt['individu'];
    	}else{
    		$krt = '';
    	}
        return $krt;
    }

    public static function getnamakrt($kodepeserta){
        $getkrt = PesertaBDT::where('kodepeserta', $kodepeserta)->where('individu.b4_k3', '1')->get();

        if($getkrt->isEmpty()){
            $var = '';
        }else{
            $var = $getkrt[0]->individu[0]['nama'];
        }

        return $var;
    }


	public static function getsummary($id, $kec){
		/*
		$indikecamatanbdt = PesertaBDT::raw(function($collection) use($kec) {
			return $collection->aggregate(array(
				array( '$match' => array(
					'kec' => $kec
				)),
				array( '$unwind' => '$individu'
				),
				array( '$match' => array(
					'individu.status' => 1
				)),
				array(
					'$count' => 'count'
				)
			));
		});

		$indikecamatanmpm = PesertaMpm::raw(function($collection) use($kec){
			return $collection->aggregate(array(
				array( '$match' => array(
					'kec' => $kec
				)),
				array( '$unwind' => '$individu'
				),
				array( '$match' => array(
					'individu.status' => 1
				)),
				array(
					'$count' => 'count'
				)
				
			));
		});

		$indikecamatan = ((!empty($indikecamatanbdt[0])) ? $indikecamatanbdt[0]->count : 0) + ((!empty($indikecamatanmpm[0])) ? $indikecamatanmpm[0]->count : 0);

		$nonikkecamatanbdt = PesertaBDT::raw(function($collection) use($kec){
			return $collection->aggregate(
			array(
				array( '$match' => array(
					'kec' => $kec
				)),
				array('$unwind' => '$individu'),
				array(
					'$match' => array(
						'$or' => array(
							array('individu.nik' => ''),
							array('individu.nik' => 'NULL')
						),
						'individu.status' => 1)
				),
				array(
					'$count' => 'count'
				)
				
			));
		});

		$nonikkecamatanmpm = PesertaMpm::raw(function($collection) use($kec){
			return $collection->aggregate(
			array(
				array( '$match' => array(
					'kec' => $kec
				)),
				array('$unwind' => '$individu'),
				array(
					'$match' => array(
						'$or' => array(
							array('individu.nik' => ''),
							array('individu.nik' => 'NULL')
						),
						'individu.status' => 1)
				),
				array(
					'$count' => 'count'
				)
				
			));
		});

		$nonikkecamatan = ((!empty($nonikkecamatanmpm[0])) ? $nonikkecamatanmpm[0]->count : 0) + ((!empty($nonikkecamatanbdt[0])) ? $nonikkecamatanbdt[0]->count : 0);

		$nikkecamatanbdt = PesertaBDT::raw(function($collection) use($kec){
			return $collection->aggregate(
			array(
				array( '$match' => array(
					'kec' => $kec
				)),
				array('$unwind' => '$individu'),
				array(
					'$match' => array(
						'individu.nik' => array(
							'$nin' => array("","NULL")
						),
						'individu.status' => 1
					)
				),
				array(
					'$count' => 'count'
				)
				
			));
		});

		$nikkecamatanmpm = PesertaMpm::raw(function($collection) use($kec){
			return $collection->aggregate(
			array(
				array( '$match' => array(
					'kec' => $kec
				)),
				array('$unwind' => '$individu'),
				array(
					'$match' => array(
						'individu.nik' => array(
							'$nin' => array("","NULL")
						),
						'individu.status' => 1
					)
				),
				array(
					'$count' => 'count'
				)
				
			));
		});

		$nikkecamatan = ((!empty($nikkecamatanmpm[0])) ? $nikkecamatanmpm[0]->count : 0) + ((!empty($nikkecamatanbdt[0])) ? $nikkecamatanbdt[0]->count : 0);

		$pkhkecamatanbdt = PesertaBDT::raw(function($collection) use($kec){
			return $collection->aggregate(
			array(
				array( '$match' => array(
					'kec' => $kec
				)),
				array('$unwind' => '$asset'),
				array(
					'$match' => array(
						'asset.spkt47' => array(
							'$nin' => array("","NULL","2", null)
						),
						'status' => 1
					)
				),
				array(
					'$count' => 'count'
				)
				
			));
		});

		$pkhkecamatanmpm = PesertaMpm::raw(function($collection) use($kec){
			return $collection->aggregate(
			array(
				array( '$match' => array(
					'kec' => $kec
				)),
				array('$unwind' => '$asset'),
				array(
					'$match' => array(
						'asset.spkt47' => array(
							'$nin' => array("","NULL","2",null)
						),
						'status' => 1
					)
				),
				array(
					'$count' => 'count'
				)
				
			));
		});

		$pkhkecamatan = ((!empty($pkhkecamatanmpm[0])) ? $pkhkecamatanmpm[0]->count : 0) + ((!empty($pkhkecamatanbdt[0])) ? $pkhkecamatanbdt[0]->count : 0);

		$kkskecamatanbdt = PesertaBDT::raw(function($collection) use($kec){
			return $collection->aggregate(
			array(
				array( '$match' => array(
					'kec' => $kec
				)),
				array('$unwind' => '$asset'),
				array(
					'$match' => array(
						'asset.spkt41' => array(
							'$nin' => array("","NULL","2", null)
						),
						'status' => 1
					)
				),
				array(
					'$count' => 'count'
				)
				
			));
		});

		$kkskecamatanmpm = PesertaMpm::raw(function($collection) use($kec){
			return $collection->aggregate(
			array(
				array( '$match' => array(
					'kec' => $kec
				)),
				array('$unwind' => '$asset'),
				array(
					'$match' => array(
						'asset.spkt41' => array(
							'$nin' => array("","NULL","2",null)
						),
						'status' => 1
					)
				),
				array(
					'$count' => 'count'
				)
				
			));
		});

		$kkskecamatan = ((!empty($kkskecamatanmpm[0])) ? $kkskecamatanmpm[0]->count : 0) + ((!empty($kkskecamatanbdt[0])) ? $kkskecamatanbdt[0]->count : 0);

		$kurkecamatanbdt = PesertaBDT::raw(function($collection) use($kec){
			return $collection->aggregate(
			array(
				array( '$match' => array(
					'kec' => $kec
				)),
				array('$unwind' => '$asset'),
				array(
					'$match' => array(
						'asset.spkt49' => array(
							'$nin' => array("","NULL","2", null)
						),
						'status' => 1
					)
				),
				array(
					'$count' => 'count'
				)
				
			));
		});

		$kurkecamatanmpm = PesertaMpm::raw(function($collection) use($kec){
			return $collection->aggregate(
			array(
				array( '$match' => array(
					'kec' => $kec
				)),
				array('$unwind' => '$asset'),
				array(
					'$match' => array(
						'asset.spkt49' => array(
							'$nin' => array("","NULL","2",null)
						),
						'status' => 1
					)
				),
				array(
					'$count' => 'count'
				)
				
			));
		});

		$kurkecamatan = ((!empty($kurkecamatanmpm[0])) ? $kurkecamatanmpm[0]->count : 0) + ((!empty($kurkecamatanbdt[0])) ? $kurkecamatanbdt[0]->count : 0);
		*/

		$kecamatan = Kecamatan::where('id_kecamatan', $kec)->where('status', true)->first();
		

		$kelurahan = Kelurahan::where('id_kecamatan', $kec)->where('status', true)->get();
		
		$listkel = [];
		foreach($kelurahan as $lskel){
			$rtjum = PesertaBDT::where('kab', '7316')->where('des', $lskel->id_kelurahan)->where('status', 1)->count();
			$rtjummpm = PesertaMpm::where('kab', '7316')->where('des', $lskel->id_kelurahan)->where('status', 1)->count();
			$jumrt = $rtjum + $rtjummpm;

			/*
			//hitung masing-masing indikator variabel
			$rt = PesertaBDT::where('kab', '7316')->where('des', $lskel->id_kelurahan)->where('status', 1)->get();
			$rtmpm = PesertaMpm::where('kab', '7316')->where('des', $lskel->id_kelurahan)->where('status', 1)->get();
			
			$valueIndikator = new PesertaBDT;
			//merge peserta bdt dan peserta mpm
			$rt->merge($rtmpm);
			
			//0 = rendah, 1 = sedang, 2 = tinggi
			$indiRendah = 0;
			$indiSedang = 1;
			$indiTinggi = 2;
			*/

			//push data to listkel
			array_push($listkel, array('key'=>$lskel->id_kelurahan,
					'jum' => $jumrt,
					'value'=>$lskel->kelurahan,
					'id_kel' => $lskel->id_kelurahan,
					/*'detail'=>
						array(
							array('kategori'=>'Rumah', 'rendah'=>5, 'sedang'=>30, 'tinggi'=>15),
							array('kategori'=>'Listrik', 'rendah'=>0, 'sedang'=>30, 'tinggi'=>0),
							array('kategori'=>'Kesehatan', 'rendah'=>0, 'sedang'=>5, 'tinggi'=>0),
							array('kategori'=>'Pendidikan', 'rendah'=>23, 'sedang'=>0, 'tinggi'=>5),
							array('kategori'=>'Pekerjaan', 'rendah'=>0, 'sedang'=>0, 'tinggi'=>0),
							array('kategori'=>'Fasilitas MCK', 'rendah'=>0, 'sedang'=>100, 'tinggi'=>0),
							array('kategori'=>'Fasilitas Memasak', 'rendah'=>20, 'sedang'=>50, 'tinggi'=>0),
							array('kategori'=>'Kelengkapan Persuratan', 'rendah'=>56, 'sedang'=>56, 'tinggi'=>0),
							array('kategori'=>'Peserta KKS/KPS', 'rendah'=>0, 'sedang'=>32, 'tinggi'=>0),
							array('kategori'=>'Peserta Program Rastra', 'rendah'=>34, 'sedang'=>78, 'tinggi'=>0),
							array('kategori'=>'Peserta Program KUR', 'rendah'=>0, 'sedang'=>72, 'tinggi'=>0),
							array('kategori'=>'Peserta Program PKH', 'rendah'=>23, 'sedang'=>45, 'tinggi'=>0),
							array('kategori'=>'Peserta KIP', 'rendah'=>0, 'sedang'=>67, 'tinggi'=>56),
							array('kategori'=>'Peserta KIS/BPJS', 'rendah'=>0, 'sedang'=>67, 'tinggi'=>87),
							array('kategori'=>'Asuransi Kesehatan Lain', 'rendah'=>35, 'sedang'=>56, 'tinggi'=>56)
						)
					)
					'detail'=> 
						array(
							array(
								'kategori'	=>	'Rumah',
								'rendah'	=>	$valueIndikator->getValueOfIndicator('rumah', $indiRendah, $rt),
								'sedang'	=>	$valueIndikator->getValueOfIndicator('rumah', $indiSedang, $rt),
								'tinggi'	=>	$valueIndikator->getValueOfIndicator('rumah', $indiTinggi, $rt)
							),
							array(
								'kategori'	=>	'Listrik',
								'rendah'	=>	$valueIndikator->getValueOfIndicator('listrik', $indiRendah, $rt),
								'sedang'	=>	$valueIndikator->getValueOfIndicator('listrik', $indiSedang, $rt),
								'tinggi'	=>	$valueIndikator->getValueOfIndicator('listrik', $indiTinggi, $rt)
							),
							array(
								'kategori'	=>	'Kesehatan',
								'rendah'	=>	$valueIndikator->getValueOfIndicator('kesehatan', $indiRendah, $rt),
								'sedang'	=>	$valueIndikator->getValueOfIndicator('kesehatan', $indiSedang, $rt),
								'tinggi'	=>	$valueIndikator->getValueOfIndicator('kesehatan', $indiTinggi, $rt)
							),
							array(
								'kategori'	=>	'Pendidikan',
								'rendah'	=>	$valueIndikator->getValueOfIndicator('pendidikan', $indiRendah, $rt),
								'sedang'	=>	$valueIndikator->getValueOfIndicator('pendidikan', $indiSedang, $rt),
								'tinggi'	=>	$valueIndikator->getValueOfIndicator('pendidikan', $indiTinggi, $rt)
							),
							array(
								'kategori'	=>	'Pekerjaan',
								'rendah'	=>	$valueIndikator->getValueOfIndicator('pekerjaan', $indiRendah, $rt),
								'sedang'	=>	$valueIndikator->getValueOfIndicator('pekerjaan', $indiSedang, $rt),
								'tinggi'	=>	$valueIndikator->getValueOfIndicator('pekerjaan', $indiTinggi, $rt)
							),
							array(
								'kategori'	=>	'Fasilitas MCK',
								'rendah'	=>	$valueIndikator->getValueOfIndicator('fasilitasmck', $indiRendah, $rt),
								'sedang'	=>	$valueIndikator->getValueOfIndicator('fasilitasmck', $indiSedang, $rt),
								'tinggi'	=>	$valueIndikator->getValueOfIndicator('fasilitasmck', $indiTinggi, $rt)
							),
							array(
								'kategori'	=>	'Fasilitas Memasak',
								'rendah'	=>	$valueIndikator->getValueOfIndicator('fasilitasmemasak', $indiRendah, $rt),
								'sedang'	=>	$valueIndikator->getValueOfIndicator('fasilitasmemasak', $indiSedang, $rt),
								'tinggi'	=>	$valueIndikator->getValueOfIndicator('fasilitasmemasak', $indiTinggi, $rt)
							),
							array(
								'kategori'	=>	'Kelengkapan Persuratan',
								'rendah'	=>	$valueIndikator->getValueOfIndicator('kelengkapanpersuratan', $indiRendah, $rt),
								'sedang'	=>	$valueIndikator->getValueOfIndicator('kelengkapanpersuratan', $indiSedang, $rt),
								'tinggi'	=>	$valueIndikator->getValueOfIndicator('kelengkapanpersuratan', $indiTinggi, $rt)
							),
							array(
								'kategori'	=>	'Peserta KKS/KPS',
								'rendah'	=>	$valueIndikator->getValueOfIndicator('pesertakks', $indiRendah, $rt),
								'sedang'	=>	$valueIndikator->getValueOfIndicator('pesertakks', $indiSedang, $rt),
								'tinggi'	=>	$valueIndikator->getValueOfIndicator('pesertakks', $indiTinggi, $rt)
							),
							array(
								'kategori'	=>	'Peserta Program Rastra',
								'rendah'	=>	$valueIndikator->getValueOfIndicator('pesertarastra', $indiRendah, $rt),
								'sedang'	=>	$valueIndikator->getValueOfIndicator('pesertarastra', $indiSedang, $rt),
								'tinggi'	=>	$valueIndikator->getValueOfIndicator('pesertarastra', $indiTinggi, $rt)
							),
							array(
								'kategori'	=>	'Peserta Program KUR',
								'rendah'	=>	$valueIndikator->getValueOfIndicator('pesertakur', $indiRendah, $rt),
								'sedang'	=>	$valueIndikator->getValueOfIndicator('pesertakur', $indiSedang, $rt),
								'tinggi'	=>	$valueIndikator->getValueOfIndicator('pesertakur', $indiTinggi, $rt)
							),
							array(
								'kategori'	=>	'Peserta Program PKH',
								'rendah'	=>	$valueIndikator->getValueOfIndicator('pesertapkh', $indiRendah, $rt),
								'sedang'	=>	$valueIndikator->getValueOfIndicator('pesertapkh', $indiSedang, $rt),
								'tinggi'	=>	$valueIndikator->getValueOfIndicator('pesertapkh', $indiTinggi, $rt)
							),
							array(
								'kategori'	=>	'Peserta KIP',
								'rendah'	=>	$valueIndikator->getValueOfIndicator('kip', $indiRendah, $rt),
								'sedang'	=>	$valueIndikator->getValueOfIndicator('kip', $indiSedang, $rt),
								'tinggi'	=>	$valueIndikator->getValueOfIndicator('kip', $indiTinggi, $rt)
							),
							array(
								'kategori'	=>	'Peserta KIS/BPJS',
								'rendah'	=>	$valueIndikator->getValueOfIndicator('kisbpjs', $indiRendah, $rt),
								'sedang'	=>	$valueIndikator->getValueOfIndicator('kisbpjs', $indiSedang, $rt),
								'tinggi'	=>	$valueIndikator->getValueOfIndicator('kisbpjs', $indiTinggi, $rt)
							),
							array(
								'kategori'	=>	'Asuransi Kesehatan Lain',
								'rendah'	=>	$valueIndikator->getValueOfIndicator('kesehatan_lain', $indiRendah, $rt),
								'sedang'	=>	$valueIndikator->getValueOfIndicator('kesehatan_lain', $indiSedang, $rt),
								'tinggi'	=>	$valueIndikator->getValueOfIndicator('kesehatan_lain', $indiTinggi, $rt)
							)
						)
					)
					*/
					)
				);
		}

		// $summary = array('id' => $id, 'kec' => $kecamatan->kecamatan, 
		// 'data' => array(array('key'=>'Jumlah Individu', 'value'=>$indikecamatan),
		// array('key'=>'Punya NIK', 'value'=>$nikkecamatan),
		// array('key'=>'Tidak Punya NIK', 'value'=>$nonikkecamatan),
		// array('key'=>'PKH', 'value'=>$pkhkecamatan),
		// array('key'=>'KKS/KPS', 'value'=>$kkskecamatan),
		// array('key'=>'KUR', 'value'=>$kurkecamatan)));

		$summary = array(
			'id'=>$id,
			'kec'=>$kecamatan->kecamatan,
			'data'=> $listkel
		);

		return $summary;
	}

	//get detail summary
	static public function getSummaryDetail($isKecamatan, $idKelurahan)
	{
		$kelurahan = Kelurahan::where('id_kelurahan', $idKelurahan)->where('status', true)->get();
		$kecamatan = Kecamatan::where('id_kecamatan', $kelurahan[0]['id_kecamatan'])->where('status', true)->first();

		$rt = PesertaBDT::where('kab', '7316')->where('des', $idKelurahan)->where('status', 1)->get();
		$rtmpm = PesertaMpm::where('kab', '7316')->where('des', $idKelurahan)->where('status', 1)->get();
		//dd($kelurahan, $rt, $rtmpm, $kecamatan);
		$listkel = [];
		$rtjum = PesertaBDT::where('kab', '7316')->where('des', $idKelurahan)->where('status', 1)->count();
		$rtjummpm = PesertaMpm::where('kab', '7316')->where('des', $idKelurahan)->where('status', 1)->count();
		$jumrt = $rtjum + $rtjummpm;
		
		$valueIndikator = new PesertaBDT;
		//merge peserta bdt dan peserta mpm
		$rt->merge($rtmpm);
		
		// $ress = $valueIndikator->getValueIndikator($rt);
		// $res = $valueIndikator->getValueOfIndicator('pendidikan', 2, $rt);
		// dd($ress, $res);
		
		//0 = rendah, 1 = sedang, 2 = tinggi
		$indiRendah = 0;
		$indiSedang = 1;
		$indiTinggi = 2;

		//define variable
		$indikator = ['rumah'];

		//push data to listkel
		array_push($listkel, array(
			'key'=>$idKelurahan,
			'jum' => $jumrt,
			'value'=>$kelurahan[0]['kelurahan'],
			'detail'=> 
				array(
					array(
						'kategori'	=>	'Rumah',
						'rendah'	=>	$valueIndikator->getValueOfIndicator('rumah', $indiRendah, $rt),
						'sedang'	=>	$valueIndikator->getValueOfIndicator('rumah', $indiSedang, $rt),
						'tinggi'	=>	$valueIndikator->getValueOfIndicator('rumah', $indiTinggi, $rt)
					),
					array(
						'kategori'	=>	'Listrik',
						'rendah'	=>	$valueIndikator->getValueOfIndicator('listrik', $indiRendah, $rt),
						'sedang'	=>	$valueIndikator->getValueOfIndicator('listrik', $indiSedang, $rt),
						'tinggi'	=>	$valueIndikator->getValueOfIndicator('listrik', $indiTinggi, $rt)
					),
					array(
						'kategori'	=>	'Kesehatan',
						'rendah'	=>	$valueIndikator->getValueOfIndicator('kesehatan', $indiRendah, $rt),
						'sedang'	=>	$valueIndikator->getValueOfIndicator('kesehatan', $indiSedang, $rt),
						'tinggi'	=>	$valueIndikator->getValueOfIndicator('kesehatan', $indiTinggi, $rt)
					),
					array(
						'kategori'	=>	'Pendidikan',
						'rendah'	=>	$valueIndikator->getValueOfIndicator('pendidikan', $indiRendah, $rt),
						'sedang'	=>	$valueIndikator->getValueOfIndicator('pendidikan', $indiSedang, $rt),
						'tinggi'	=>	$valueIndikator->getValueOfIndicator('pendidikan', $indiTinggi, $rt)
					),
					array(
						'kategori'	=>	'Pekerjaan',
						'rendah'	=>	$valueIndikator->getValueOfIndicator('pekerjaan', $indiRendah, $rt),
						'sedang'	=>	$valueIndikator->getValueOfIndicator('pekerjaan', $indiSedang, $rt),
						'tinggi'	=>	$valueIndikator->getValueOfIndicator('pekerjaan', $indiTinggi, $rt)
					),
					array(
						'kategori'	=>	'Fasilitas MCK',
						'rendah'	=>	$valueIndikator->getValueOfIndicator('fasilitasmck', $indiRendah, $rt),
						'sedang'	=>	$valueIndikator->getValueOfIndicator('fasilitasmck', $indiSedang, $rt),
						'tinggi'	=>	$valueIndikator->getValueOfIndicator('fasilitasmck', $indiTinggi, $rt)
					),
					array(
						'kategori'	=>	'Fasilitas Memasak',
						'rendah'	=>	$valueIndikator->getValueOfIndicator('fasilitasmemasak', $indiRendah, $rt),
						'sedang'	=>	$valueIndikator->getValueOfIndicator('fasilitasmemasak', $indiSedang, $rt),
						'tinggi'	=>	$valueIndikator->getValueOfIndicator('fasilitasmemasak', $indiTinggi, $rt)
					),
					array(
						'kategori'	=>	'Kelengkapan Persuratan',
						'rendah'	=>	$valueIndikator->getValueOfIndicator('kelengkapanpersuratan', $indiRendah, $rt),
						'sedang'	=>	$valueIndikator->getValueOfIndicator('kelengkapanpersuratan', $indiSedang, $rt),
						'tinggi'	=>	$valueIndikator->getValueOfIndicator('kelengkapanpersuratan', $indiTinggi, $rt)
					),
					array(
						'kategori'	=>	'Peserta KKS/KPS',
						'rendah'	=>	$valueIndikator->getValueOfIndicator('pesertakks', $indiRendah, $rt),
						'sedang'	=>	$valueIndikator->getValueOfIndicator('pesertakks', $indiSedang, $rt),
						'tinggi'	=>	$valueIndikator->getValueOfIndicator('pesertakks', $indiTinggi, $rt)
					),
					array(
						'kategori'	=>	'Peserta Program Rastra',
						'rendah'	=>	$valueIndikator->getValueOfIndicator('pesertarastra', $indiRendah, $rt),
						'sedang'	=>	$valueIndikator->getValueOfIndicator('pesertarastra', $indiSedang, $rt),
						'tinggi'	=>	$valueIndikator->getValueOfIndicator('pesertarastra', $indiTinggi, $rt)
					),
					array(
						'kategori'	=>	'Peserta Program KUR',
						'rendah'	=>	$valueIndikator->getValueOfIndicator('pesertakur', $indiRendah, $rt),
						'sedang'	=>	$valueIndikator->getValueOfIndicator('pesertakur', $indiSedang, $rt),
						'tinggi'	=>	$valueIndikator->getValueOfIndicator('pesertakur', $indiTinggi, $rt)
					),
					array(
						'kategori'	=>	'Peserta Program PKH',
						'rendah'	=>	$valueIndikator->getValueOfIndicator('pesertapkh', $indiRendah, $rt),
						'sedang'	=>	$valueIndikator->getValueOfIndicator('pesertapkh', $indiSedang, $rt),
						'tinggi'	=>	$valueIndikator->getValueOfIndicator('pesertapkh', $indiTinggi, $rt)
					),
					array(
						'kategori'	=>	'Peserta KIP',
						'rendah'	=>	$valueIndikator->getValueOfIndicator('kip', $indiRendah, $rt),
						'sedang'	=>	$valueIndikator->getValueOfIndicator('kip', $indiSedang, $rt),
						'tinggi'	=>	$valueIndikator->getValueOfIndicator('kip', $indiTinggi, $rt)
					),
					array(
						'kategori'	=>	'Peserta KIS/BPJS',
						'rendah'	=>	$valueIndikator->getValueOfIndicator('kisbpjs', $indiRendah, $rt),
						'sedang'	=>	$valueIndikator->getValueOfIndicator('kisbpjs', $indiSedang, $rt),
						'tinggi'	=>	$valueIndikator->getValueOfIndicator('kisbpjs', $indiTinggi, $rt)
					),
					array(
						'kategori'	=>	'Asuransi Kesehatan Lain',
						'rendah'	=>	$valueIndikator->getValueOfIndicator('kesehatan_lain', $indiRendah, $rt),
						'sedang'	=>	$valueIndikator->getValueOfIndicator('kesehatan_lain', $indiSedang, $rt),
						'tinggi'	=>	$valueIndikator->getValueOfIndicator('kesehatan_lain', $indiTinggi, $rt)
					)
				)
			)
		);

		$summary = array(
			'id'	=>	$isKecamatan,
			'kec'	=>	$idKelurahan,
			'data'	=>	$listkel
		);

		return $summary;
	}

	public function getValueIndikator($data)
	{
		$result = [];
		//do looping, for now, skip looping
		foreach ($data as $key => $isData) {
			//set initial value
			$dataRt = $isData['datart'][0];
			$dataAsset = $isData['asset'][0];
			$dataIndividu = $isData['individu'];
			
			//indikator rumah
			$tempResult['rumah'] = $this->indiRumah($this->isNotNullData($dataRt['b3_k1a']), $this->isNotNullData($dataRt['b3_k1b']), $this->isNotNullData($dataRt['b3_k3']), $this->isNotNullData($dataRt['b3_k4a']));

			//indikator listrik
			$tempResult['listrik'] = $this->indiListrik($this->isNotNullData($dataRt['b3_k9a']), $this->isNotNullData($dataRt['b3_k9b']));

			foreach ($dataIndividu as $key => $isDataIndividu) {
				//indikator kesehatan => individu
				$tempResult['kesehatan'][$key] = $this->indiKesehatan($this->isNotNullData($isDataIndividu['b4_k13']), $this->isNotNullData($isDataIndividu['b4_k14']));

				//indikator pendidikan
				$tempResult['pendidikan'][$key] = $this->indiPendidikan($this->isNotNullData($isDataIndividu['b4_k15']), $this->isNotNullData($isDataIndividu['b4_k16']), $this->isNotNullData($isDataIndividu['b4_k17']), $this->isNotNullData($isDataIndividu['b4_k18']));
				
				//indikator pekerjaan
				$tempResult['pekerjaan'][$key] = $this->indiPekerjaan($this->isNotNullData($isDataIndividu['b4_k19a']));
				
				//indikator kelengkapan persuratan
				$tempResult['kelengkapanpersuratan'][$key] = $this->indiKelengkapanPersuratan($this->isNotNullData($isDataIndividu['b4_k9']), $this->isNotNullData($isDataIndividu['b4_k11']));
			}

			//indikator fasilitas MCK
			$tempResult['fasilitasmck'] = $this->indiFasilitasMck($this->isNotNullData($dataRt['b3_k11a']));

			//indikator fasilitas memasak
			$tempResult['fasilitasmemasak'] = $this->indiFasilitasMemasak($this->isNotNullData($dataRt['b3_k10']), $this->isNotNullData($dataAsset['b5_k1a']));

			//indikator peserta kks/kps
			//$a = $this->isNotNullData($dataAsset['b5_k6a']);
			$indiKks = isset($dataAsset['b5_k6a']) ? $dataAsset['b5_k6a'] : null;
			$tempResult['pesertakks'] = $this->indiPesertaKks($indiKks);

			//indikator peserta program rastra
			$indiRastra = isset($dataAsset['b5_k6h']) ? $dataAsset['b5_k6h'] : null;
			$tempResult['pesertarastra'] = $this->indiPesertaRastra($indiRastra);

			//indikator peserta program kur
			$indiKur = isset($dataAsset['b5_k6i']) ? $dataAsset['b5_k6i'] : null;
			$tempResult['pesertakur'] = $this->indiPesertaKur($indiKur);

			//indikator peserta program pkh
			$indiPkh = isset($dataAsset['b5_k6g']) ? $dataAsset['b5_k6g'] : null;
			$tempResult['pesertapkh'] = $this->indiPesertaPkh($indiPkh);

			//indikator kip
			$indiKip = isset($dataAsset['b5_k6b']) ? $dataAsset['b5_k6b'] : null;
			$tempResult['kip'] = $this->indiKip($indiKip);

			//indikator kis/bpjs
			$indiKis = isset($dataAsset['b5_r6c']) ? $dataAsset['b5_r6c'] : null;
			$indiBpjs = isset($dataAsset['b5_r6d']) ? $dataAsset['b5_r6d'] : null;
			$tempResult['kisbpjs'] = $this->indiKisBpjs($indiKis, $indiBpjs);

			//indikator kesehatan lain
			$indiKesehatanLain = isset($dataAsset['b5_r6d']) ? $dataAsset['b5_r6d'] : null;
			$tempResult['kesehatan_lain'] = $this->indiKesehatanLain($indiKesehatanLain);

			//count each
			//array push to result var
			array_push($result, $tempResult);
		}
		return $result;
	}

	//check if value is null
	public function isNotNullData($val)
	{
		$res = isset($val) ? $val : null;

		return $res;
	}

	//getEachValueOfIndicator
	public function getValueOfIndicator($type, $val, $data)
	{
		$result = 0;
		$dataCallIndicator = $this->getValueIndikator($data);
		foreach ($dataCallIndicator as $keyData => $data) {
			//dd($data);
			foreach ($data as $key => $value) {
				if ($key == $type) {
					if(is_array($value)) {
						if ($val == $value[0]) {
							$result += 1;
						}
						// foreach ($value as $isVal) {
						// 	if ($val == $isVal) {
						// 		$result += 1;
						// 	}
						// }
					} else {
						if ($val == $value) {
							$result += 1;
						}
					}
				}
			}
		}
		return $result;
	}
	
	//perhitungan masing-masing nilai indikator
	//#15 rumah
    public function indiRumah($valueOne, $valueTwo, $valueThree, $valueFour)
    {
        //b3_k1a
        //b3_k1b
        //b3_k3
        //b3_k4a
        if ($valueOne == 1 && $valueTwo == 1) {
            //cek variabel indikator yang lain
            if (($valueThree == 1 || $valueThree == 2 || $valueThree == 3 || $valueThree == 4) && ($valueFour == 1 || $valueFour == 2)) {
                $status = 2; //tinggi
            } else {
                $status = 0; //rendah
            }
        } else {
            $status = 1; //sedang
        }

        return $status;
	}

	//#14 listrik
    public function indiListrik($valueOne, $valueTwo)
    {
        //b3_k9a
        //b3_k9b
        $status = 0; //rendah
        if ($valueOne == 1) {
            $status = 2;
        } elseif ($valueOne == 2) {
            $status = 1;
        } elseif ($valueOne == 3) {
            $status = 0;
        }

        return $status;
	}
	
	//#13 kesehatan
    public function indiKesehatan($valueOne, $valueTwo)
    {
        //b4_k13
        //b4_k14
        $status = 0; //rendah
        if ($valueOne == 0 && $valueTwo == 0) {
            $status = 2; //tinggi
        }

        return $status;
	}
	
	//#12 pendidikan
	public function indiPendidikan($valueOne, $valueTwo, $valueThree, $valueFour)
    {
        //b4_k15
        //b4_k16
        //b4_k17
        //b4_k18
        if ($valueOne == 2) {
            //cek variabel indikator yang lain
            if ($valueTwo == 10 && $valueThree == 10 && $valueFour == 10) {
                $status = 2;
            } elseif ($valueTwo = $valueThree = $valueFour == 7 || $valueTwo = $valueThree = $valueFour == 8 || $valueTwo = $valueThree = $valueFour == 9) {
                $status = 1;
            } else {
                $status = 0;
            }
        } else {
            $status = 0;
        }

        return $status;
	}
	
	 //#11 pekerjaan
	public function indiPekerjaan($value)
	{
		//on individu
		//b4_k19a
		$status = 1;
		if ($value == 1) { //tinggi
			$status = 2;
		} elseif ($value == 2) { //rendah
			$status = 0;
		}

		return $status;
	}

	//#10 fasilitas MCK
    public function indiFasilitasMck($valueOne)
    {
        //b3_k11a -> hanya di cek
        $status = 0; //rendah
        if ($valueOne == 1) {
            $status = 2; //tinggi
        } elseif ($valueOne == 2) {
            $status = 1; //sedang
        } elseif ($valueOne == 3 || $valueOne == 4) {
            $status = 0; //rendah
		}
		
		return $status;
	}
	
	//#9 fasilitas memasak
    public function indiFasilitasMemasak($valueOne, $valueTwo)
    {
		//b3_k10
		//b5_k1a
        $status = 1;
        if (($valueOne == 1 || $valueOne == 2) && ($valueTwo == 1)) { //tinggi
            $status = 2;
        } elseif (($valueOne == 8 || $valueOne == 9) && $valueTwo == 2) { //rendah
            $status = 0;
        }

        return $status;
	}
	
	//#8 kelengkapan persuratan
    public function indiKelengkapanPersuratan($valueOne, $valueTwo)
    {
        //b4_k9
        //b4_k11
        $status = 0;
        if ($valueOne == 1 && $valueTwo == 15) { //tinggi
            $status = 2;
        } elseif ($valueOne == 0 && $valueTwo == 0) { //rendah
            $status = 0;
        } else { // sedang
            $status = 1;
        }

        return $status;
	}
	
	//#7 peserta kks/kps
    public function indiPesertaKks($value)
    {
        //b5_k6a
        $status = 0;
        if ($value == 1) {
            $status = 2;
        }

        return $status;
	}
	
	//#6 peserta program rastra
    public function indiPesertaRastra($value)
    {
        //b5_k6h
        $status = 0;
        if ($value == 1) {
            $status = 2;
        }

        return $status;
	}
	
	//#1 kesehatan lain
    public function indiKesehatanLain($value)
    {
        //b5_r6f
        $status = 0;
        if ($value == 2) {
            $status = 2; //tinggi
        }

        return $status;
    }

    //#2 kis/bpjs
    public function indiKisBpjs($valueOne, $valueTwo)
    {
        $status = 0;
        if ($valueOne == 1 && $valueTwo == 2) { //tinggi
            $status = 2;
        } elseif ($valueOne == 1 && $valueTwo == 1) {
            $status = 0;
        }

        return $status;
    }

    //#3 kip
    public function indiKip($value)
    {
        //b5_r6b
        $status = 0;
        if ($value == 1) {
            $status = 2;
        }

        return $status;
    }

    //#4 peserta program PKH
    public function indiPesertaPkh($value)
    {
        //b5_k6g
        $status = 0;
        if ($value == 1) {
            $status = 2;
        }

        return $status;
    }

    //#5 peserta program KUR
    public function indiPesertaKur($value)
    {
        //b5_k6i
        $status = 0;
        if ($value == 1) {
            $status = 2;
        }

        return $status;
    }
}