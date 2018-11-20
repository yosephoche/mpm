<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

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

		$kecamatan = Kecamatan::where('id_kecamatan', $kec)->where('status', true)->first();

		$kelurahan = Kelurahan::where('id_kecamatan', $kec)->where('status', true)->get();
		
		$listkel = [];
		foreach($kelurahan as $lskel){
			array_push($listkel, array('key'=>$lskel->id_kelurahan,
					'value'=>$lskel->kelurahan,
					'detail'=> 
						array(array('kategori'=>'Rumah', 'rendah'=>0, 'sedang'=>0, 'tinggi'=>0),
						array('kategori'=>'Listrik', 'rendah'=>0, 'sedang'=>0, 'tinggi'=>0),
						array('kategori'=>'Kesehatan', 'rendah'=>0, 'sedang'=>0, 'tinggi'=>0),
						array('kategori'=>'Pendidikan', 'rendah'=>0, 'sedang'=>0, 'tinggi'=>0),
						array('kategori'=>'Pekerjaan', 'rendah'=>0, 'sedang'=>0, 'tinggi'=>0),
						array('kategori'=>'Fasilitas MCK', 'rendah'=>0, 'sedang'=>0, 'tinggi'=>0),
						array('kategori'=>'Fasilitas Memasak', 'rendah'=>0, 'sedang'=>0, 'tinggi'=>0),
						array('kategori'=>'Kelengkapan Persuratan', 'rendah'=>0, 'sedang'=>0, 'tinggi'=>0),
						array('kategori'=>'Peserta KKS/KPS', 'rendah'=>0, 'sedang'=>0, 'tinggi'=>0),
						array('kategori'=>'Peserta Program Rastra', 'rendah'=>0, 'sedang'=>0, 'tinggi'=>0),
						array('kategori'=>'Peserta Program KUR', 'rendah'=>0, 'sedang'=>0, 'tinggi'=>0),
						array('kategori'=>'Peserta Program PKH', 'rendah'=>0, 'sedang'=>0, 'tinggi'=>0),
						array('kategori'=>'Peserta KIP', 'rendah'=>0, 'sedang'=>0, 'tinggi'=>0),
						array('kategori'=>'Peserta KIS/BPJS', 'rendah'=>0, 'sedang'=>0, 'tinggi'=>0),
						array('kategori'=>'Asuransi Kesehatan Lain', 'rendah'=>0, 'sedang'=>0, 'tinggi'=>0),
						
						)
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

		$summary = array('id'=>$id, 'kec'=>$kecamatan->kecamatan,
		'data'=> $listkel
		);

		return $summary;
	}

}