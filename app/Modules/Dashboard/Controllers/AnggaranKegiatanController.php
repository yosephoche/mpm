<?php

namespace App\Modules\Dashboard\Controllers;

use Illuminate\Http\Request;
use App\Models\Skpd;
use App\Models\IndikatorVariabel;
use App\Models\OpsiIndikator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\JenisKegiatan;
use App\Models\IndikatorKegiatan;
use App\Models\AnggaranKegiatan;

class AnggaranKegiatanController extends Controller
{
	public function authOpdCheck()
	{
		return (auth()->guard('admin')->user()->status_admin == 3) ? true : false;
	}

	/**
	 * Route => /anggaran-kegiatan
	 * 
	 * @method get index()
	 */
	public function index()
	{
		if ($this->authOpdCheck()) {
			$anggaranKegiatan = AnggaranKegiatan::where('status', 1)->paginate(10);
			return view('Dashboard::pages.anggaran-kegiatan.index')
					->withAnggaran($anggaranKegiatan)
					->withTitle("Data Anggaran Kegiatan");
		} else {
			return redirect('/dashboard');
		}
	}

	/**
	 * Route => /master/jenis-kegiatan/input
	 * 
	 * @method get jenisKegiatanCreate()
	 */
	public function create()
	{
		if ($this->authOpdCheck()) {
			$jenisKegiatan = JenisKegiatan::where('status', 1)->get();
			return view('Dashboard::pages.anggaran-kegiatan.create')
				->withTitle('Tambah Data Anggaran Kegiatan')
				->withJenis($jenisKegiatan);
		} else {
			return redirect('/dashboard');
		}
	}

	/**
	 * Route => /master/jenis-kegiatan/input
	 * 
	 * @method post jenisKegiatanSave()
	 */
	public function save(Request $request)
	{
		/*
		$lastJenisKegiatanKode = JenisKegiatan::where('status', 1)->orderBy('kode', 'DESC')->get();
		if ($lastJenisKegiatanKode->isEmpty()) {
			$kode = 'jk001';
		} else {
			$getKode = substr($lastJenisKegiatanKode[0]->kode, 1);
			$kode = 'jk'.str_pad((int)$getKode + 1, 3, '0', STR_PAD_LEFT);
		}
		*/

		$anggaranKegiatan = new AnggaranKegiatan;
		$anggaranKegiatan->anggaran_jenis_kegiatan = $request->get('anggaran_jenis_kegiatan');
		$anggaranKegiatan->anggaran_nama_kegiatan = $request->get('anggaran_nama_kegiatan');
		$anggaranKegiatan->anggaran_besaran = $request->get('anggaran_besaran');
		$anggaranKegiatan->anggaran_tahun_kegiatan = $request->get('anggaran_tahun_kegiatan');
		$anggaranKegiatan->opd_id = auth()->guard('admin')->user()->opd;
		$anggaranKegiatan->status = 1;

		if ($anggaranKegiatan->save()) {
			$pesan = array('success' => 1, 'message' => 'Data Anggaran Kegiatan berhasil disimpan');
		} else {
			$pesan = array('success' => 0, 'message' => 'Data Anggaran Kegiatan gagal disimpan');
		}

		return json_encode($pesan);
	}

	/**
	 * Route => /master/jenis-kegiatan/update/{idJenis}
	 * 
	 * @method get jenisKegiatanEdit()
	 * 
	 * @param _id $idJenis
	 */
	public function edit($idAnggaran)
	{
		if ($this->authOpdCheck()) {
			$jenisKegiatan = JenisKegiatan::where('status', 1)->get();
			$anggaranKegiatan = AnggaranKegiatan::where('_id', $idAnggaran)->where('status', 1)->get();
			if ($anggaranKegiatan->isEmpty()) {
				//not found jenis kegiatan
			} else {
				return view('Dashboard::pages.anggaran-kegiatan.edit')
					->withAnggaran($anggaranKegiatan[0])
					->withJenis($jenisKegiatan)
					->withTitle('Edit Data Anggaran Kegiatan');
			}
		} else {
			return redirect('/dashboard');
		}
	}

	/**
	 * Route => /master/jenis-kegiatan/update
	 * 
	 * @method post jenisKegiatanUpdate()
	 */
	public function update(Request $request)
	{
		$anggaranKegiatan = AnggaranKegiatan::where('_id',  $request->get('idAnggaran'))->where('status', 1)->get();

		if (!$anggaranKegiatan) {
			//not found id
			$pesan = array('success' => 0, 'message' => 'Mohon maaf, Data tidak ditemukan');
		} else {
			$anggaranKegiatan->anggaran_nama_kegiatan = $request->get('anggaran_nama_kegiatan');
			$anggaranKegiatan->anggaran_jenis_kegiatan = $request->get('anggaran_jenis_kegiatan');
			$anggaranKegiatan->anggaran_besaran = $request->get('anggaran_besaran');
			$anggaranKegiatan->anggaran_tahun_kegiatan = $request->get('anggaran_tahun_kegiatan');

			if ($anggaranKegiatan->save()) {
				//success
				$pesan = array('success' => 1, 'message' => 'Terima kasih. Data berhasil diperbaharui');
			} else {
				$pesan = array('success' => 0, 'message' => 'Terima kasih. Data gagal diperbaharui');
			}
		}

		return json_encode($pesan);
	}

	/**
	 * Route => /master/jenis-kegiatan/delete/{idJenis}
	 * 
	 * @method get jenisKegiatanDelete()
	 * 
	 * @param _id $idJenis
	 */
	public function jenisKegiatanDelete($idJenis)
	{
		$thisKegiatan = JenisKegiatan::where('_id', $idJenis)->where('status', 1)->first();

		if (!$thisKegiatan) {
			//not found id
			$pesan = array('success' => 0, 'message' => 'Mohon maaf, Data tidak ditemukan');
		} else {
			$thisKegiatan->status = 0;

			if ($thisKegiatan->save()) {
				//success
				$pesan = array('success' => 1, 'message' => 'Terima kasih. Data berhasil dihapus');
			} else {
				$pesan = array('success' => 0, 'message' => 'Terima kasih. Data gagal dihapus');
			}
		}

		return json_encode($pesan);
	}

	//master indikator kegiatan
	/**
	 * Route => /master/indikator-kegiatan
	 * 
	 * @method get indikatorKegiatanIndex()
	 */
	public function indikatorKegiatanIndex()
	{
		if ($this->authSuperCheck()) {
			$indikatorKegiatan = IndikatorKegiatan::where('status', 1)->paginate(15);
			return view('Dashboard::pages.master.indikator-kegiatan.index')
					->withIndikator($indikatorKegiatan)
					->withTitle("Master Data indikator Kegiatan");
		} else {
			return redirect('/dashboard');
		}
	}

	/**
	 * Route => /master/Indikator-kegiatan/input
	 * 
	 * @method get IndikatorKegiatanCreate()
	 */
	public function indikatorKegiatanCreate()
	{
		if ($this->authSuperCheck()) {
			$indikatorVariabel = IndikatorVariabel::where('status', 1)->get();
			return view('Dashboard::pages.master.indikator-kegiatan.create')
				->withTitle('Tambah Data Master Indikator Kegiatan')
				->withIndikator($indikatorVariabel);
		} else {
			return redirect('/dashboard');
		}
	}

	/**
	 * Route => /master/Indikator-kegiatan/input
	 * 
	 * @method post IndikatorKegiatanSave()
	 */
	public function indikatorKegiatanSave(Request $request)
	{
		// $lastIndikatorKegiatanKode = IndikatorKegiatan::where('status', 1)->orderBy('kode', 'DESC')->get();
		// if ($lastIndikatorKegiatanKode->isEmpty()) {
		// 	$kode = 'ik001';
		// } else {
		// 	$getKode = substr($lastIndikatorKegiatanKode[0]->kode, 1);
		// 	$kode = 'ik'.str_pad((int)$getKode + 1, 3, '0', STR_PAD_LEFT);
		// }

		$newKegiatan = new IndikatorKegiatan;
		//$newKegiatan->kode = $kode;
		$newKegiatan->kategori_name = $request->get('name_indikator_kegiatan');
		$newKegiatan->status = 1;
		$newKegiatan->datavariable = array(
			array_merge(json_decode($request->get('rtVar'), true))
			);

		if ($newKegiatan->save()) {
			$pesan = array('success' => 1, 'message' => 'Data Indikator Kegiatan berhasil disimpan');
		} else {
			$pesan = array('success' => 0, 'message' => 'Data Indikator Kegiatan gagal disimpan');
		}

		return json_encode($pesan);
	}

	/**
	 * Route => /master/Indikator-kegiatan/update/{idIndikator}
	 * 
	 * @method get IndikatorKegiatanEdit()
	 * 
	 * @param _id $idIndikator
	 */
	public function indikatorKegiatanEdit($idIndikator)
	{
		if ($this->authSuperCheck()) {
			$thisIndikatorKegiatan = IndikatorKegiatan::where('_id', $idIndikator)->where('status', 1)->get();
			$indikatorVariabel = IndikatorVariabel::where('status', 1)->get();
			if ($thisIndikatorKegiatan->isEmpty()) {
				//not found Indikator kegiatan
			} else {
				return view('Dashboard::pages.master.indikator-kegiatan.edit')
					->withKegiatan($thisIndikatorKegiatan[0])
					->withIndikator($indikatorVariabel)
					->withTitle('Edit Data Master Indikator Kegiatan');
			}
		} else {
			return redirect('/dashboard');
		}
	}

	/**
	 * Route => /master/Indikator-kegiatan/update
	 * 
	 * @method post IndikatorKegiatanUpdate()
	 */
	public function indikatorKegiatanUpdate(Request $request)
	{
		$thisKegiatan = IndikatorKegiatan::where('_id', $request->get('idIndikator'))->where('status', 1)->first();

		if (!$thisKegiatan) {
			//not found id
			$pesan = array('success' => 0, 'message' => 'Mohon maaf, Data tidak ditemukan');
		} else {
			$thisKegiatan->name = $request->get('name_Indikator_kegiatan');
			$thisKegiatan->datavariable = array(
				array_merge(json_decode($request->get('rtVar'), true))
				);
			if ($thisKegiatan->save()) {
				//success
				$pesan = array('success' => 1, 'message' => 'Terima kasih. Data berhasil diperbaharui');
			} else {
				$pesan = array('success' => 0, 'message' => 'Terima kasih. Data gagal diperbaharui');
			}
		}

		return json_encode($pesan);
	}

	/**
	 * Route => /master/Indikator-kegiatan/delete/{idIndikator}
	 * 
	 * @method get IndikatorKegiatanDelete()
	 * 
	 * @param _id $idIndikator
	 */
	public function indikatorKegiatanDelete($idIndikator)
	{
		$thisKegiatan = IndikatorKegiatan::where('_id', $idIndikator)->where('status', 1)->first();

		if (!$thisKegiatan) {
			//not found id
			$pesan = array('success' => 0, 'message' => 'Mohon maaf, Data tidak ditemukan');
		} else {
			$thisKegiatan->status = 0;

			if ($thisKegiatan->save()) {
				//success
				$pesan = array('success' => 1, 'message' => 'Terima kasih. Data berhasil dihapus');
			} else {
				$pesan = array('success' => 0, 'message' => 'Terima kasih. Data gagal dihapus');
			}
		}

		return json_encode($pesan);
	}
}
