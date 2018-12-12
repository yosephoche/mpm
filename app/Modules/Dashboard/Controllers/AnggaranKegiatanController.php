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
use App\Models\TahunAnggaran;

class AnggaranKegiatanController extends Controller
{
	public function authOpdCheck()
	{
		return (auth()->guard('admin')->user()->status_admin == 3 || auth()->guard('admin')->user()->status_admin == 0) ? true : false;
	}

	/**
	 * Route => /anggaran-kegiatan
	 * 
	 * @method get index()
	 */
	public function index()
	{
		if ($this->authOpdCheck()) {
			$filterTahunAnggaran = empty($_GET['tahun']) ? false : $_GET['tahun'];
			if ($filterTahunAnggaran) {
				$anggaranKegiatan = AnggaranKegiatan::where('status', 1)->where('anggaran_tahun_kegiatan', $filterTahunAnggaran)->paginate(10);
			} else {
				$anggaranKegiatan = AnggaranKegiatan::where('status', 1)->paginate(10);
			}
			$tahunAnggaran = TahunAnggaran::where('status', 1)->get();
			return view('Dashboard::pages.anggaran-kegiatan.index')
					->withAnggaran($anggaranKegiatan)
					->withTahun($tahunAnggaran)
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
			$indikatorKegiatan = IndikatorKegiatan::where('status', 1)->get();
			$tahunAnggaran = TahunAnggaran::where('status', 1)->get();
			return view('Dashboard::pages.anggaran-kegiatan.create')
				->withTitle('Tambah Data Anggaran Kegiatan')
				->withJenis($jenisKegiatan)
				->withTahun($tahunAnggaran)
				->withIndikator($indikatorKegiatan);
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
		$anggaranKegiatan->anggaran_besaran = (int)$request->get('anggaran_besaran');
		$anggaranKegiatan->anggaran_tahun_kegiatan = $request->get('anggaran_tahun_kegiatan');
		$anggaranKegiatan->anggaran_indikator_kegiatan = $request->get('anggaran_indikator_kegiatan');
		$anggaranKegiatan->opd_id = !empty(auth()->guard('admin')->user()->opd) ? auth()->guard('admin')->user()->opd : '0';
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
	public function delete($idAnggaran)
	{
		$anggaranKegiatan = AnggaranKegiatan::where('_id', $idAnggaran)->where('status', 1)->first();

		if (!$anggaranKegiatan) {
			//not found id
			$pesan = array('success' => 0, 'message' => 'Mohon maaf, Data tidak ditemukan');
		} else {
			$anggaranKegiatan->status = 0;

			if ($anggaranKegiatan->save()) {
				//success
				$pesan = array('success' => 1, 'message' => 'Terima kasih. Data berhasil dihapus');
			} else {
				$pesan = array('success' => 0, 'message' => 'Terima kasih. Data gagal dihapus');
			}
		}

		return json_encode($pesan);
	}
	
	/**
	 * Route => /anggaran-kegiatan/detail/{idAnggaran}
	 * 
	 * @method get detail()
	 * 
	 * @param _id $idAnggaran
	 */
	public function detail($idAnggaran)
	{
		if ($this->authOpdCheck()) {
			$jenisKegiatan = JenisKegiatan::where('status', 1)->get();
			$anggaranKegiatan = AnggaranKegiatan::where('_id', $idAnggaran)->where('status', 1)->get();
			$indikatorKegiatan = IndikatorKegiatan::where('status', 1)->get();
			if ($anggaranKegiatan->isEmpty()) {
				//not found jenis kegiatan
				return redirect('/dashboard');
			} else {
				return view('Dashboard::pages.anggaran-kegiatan.detail')
					->withAnggaran($anggaranKegiatan[0])
					->withJenis($jenisKegiatan)
					->withIndikator($indikatorKegiatan)
					->withTitle('Detail Data Anggaran Kegiatan');
			}
		} else {
			return redirect('/dashboard');
		}
	}
}
