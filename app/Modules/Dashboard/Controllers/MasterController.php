<?php

namespace App\Modules\Dashboard\Controllers;

use Illuminate\Http\Request;
use App\Models\Skpd;
use App\Models\IndikatorVariabel;
use App\Models\OpsiIndikator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MasterController extends Controller
{
	public function indivariabel(){
		if(auth()->guard('admin')->user()->status_admin == 0){
			/*$skpd = Skpd::where('status', 1)->get();*/
			return view('Dashboard::pages.master.indikator-variabel');
		}else{
			return redirect('/dashboard');
		}
	}

	public function postindivariabel(Request $request){
		$getindi = IndikatorVariabel::where('status', 1)->orderBy('_id', 'DESC')->get();
		if($getindi->isEmpty()){
			$kode = 'spkt1';
		}else{
			$getkode = substr($getindi[0]->kode, 4);
			$kode = 'spkt'.((int)$getkode + 1);
		}

		$getindikode = IndikatorVariabel::where('kode_variabel', $request->get('kode_variabel'))->where('status', 1)->get();
		if($getindikode->isEmpty()){
			$indi = new IndikatorVariabel;
			$indi->kode = $kode;
			$indi->tingkat = $request->get('tingkat_variabel');
			$indi->kode_variabel = $request->get('kode_variabel');
			$indi->nama = $request->get('nama_variabel');
			$indi->caraisi = $request->get('cara_isi');
			$indi->jenisindikator = $request->get('jenis_indikator');
			$indi->ketsatuan = $request->get('ket_satuan');
			$indi->pendaftaran = $request->get('pendaftaran');
			$indi->verifikasi = $request->get('verifikasi');
			$indi->status = 1;
			if($indi->save()){
				$pesan = array('success' => 1, 'message' => 'Terima kasih. Indikator variabel berhasil tersimpan.');
			}else{
				$pesan = array('success' => 0, 'message' => 'Mohon maaf. Indikator variabel gagal tersimpan.');
			}
		}else{
			$pesan = array('success' => 0, 'message' => 'Mohon maaf. Kode variabel telah digunakan.');			
		}

		return json_encode($pesan);
	}

	public function indivariabeldelete($idvar){
		$getindi = IndikatorVariabel::where('_id', $idvar)->where('status', 1)->get();
		if($getindi->isEmpty()){
			$pesan = array('success' => 0, 'message' => 'Mohon maaf. Indikator variabel tidak ditemukan.');
		}else{
			$getuseindi = OpsiIndikator::where('kode_variabel', $getindi[0]->kode)->where('status', 1)->get();
			if($getuseindi->isEmpty()){
				$indi = IndikatorVariabel::where('_id', $idvar)->where('status', 1)->update([
					'status' => 0
				]);
				if($indi){
					$pesan = array('success' => 1, 'message' => 'Terima kasih. Indikator variabel berhasil terhapus.');
				}else{
					$pesan = array('success' => 0, 'message' => 'Mohon maaf. Indikator variabel gagal terhapus.');
				}
			}else{
				$pesan = array('success' => 0, 'message' => 'Mohon maaf. Indikator variabel sedang digunakan.');
			}
		}

		return json_encode($pesan);

	}

	public function indivariabelupdate($idvar){
		if(auth()->guard('admin')->user()->status_admin == 0){
			$indi = IndikatorVariabel::where('_id', $idvar)->where('status', 1)->get();
			$skpd = Skpd::where('status', 1)->get();

			return view('Dashboard::pages.master.indikator-variabel-update', ['indi' => $indi, 'skpd' => $skpd]);
		}else{
			return redirect('/dashboard');
		}
	}

	public function indivariabelpostupdate(Request $request){
		$getindi = IndikatorVariabel::where('_id', $request->get('idvar'))->where('status', 1)->get();

		if($getindi->isEmpty()){
			$pesan = array('success' => 0, 'message' => 'Mohon maaf. Indikator Variabel tidak ditemukan');
		}else{
			$indi = IndikatorVariabel::where('_id', $request->get('idvar'))->where('status', 1)->first();
			$indi->tingkat = $request->get('tingkat_variabel');
			$indi->kode_variabel = $request->get('kode_variabel');
			$indi->nama = $request->get('nama_variabel');
			$indi->caraisi = $request->get('cara_isi');
			$indi->ketsatuan = $request->get('ket_satuan');
			$indi->pendaftaran = $request->get('pendaftaran');
			$indi->verifikasi = $request->get('verifikasi');
			$indi->jenisindikator = $request->get('jenis_indikator');

			if($indi->save()){
				$pesan = array('success' => 1, 'message' => 'Terima kasih. Indikator variabel berhasil disunting.');
			}else{
				$pesan = array('success' => 0, 'message' => 'Mohon maaf. Indikator variabel gagal disunting.');
			}
		}

		return json_encode($pesan);
	}

	public function listindivariabel(){
		if(auth()->guard('admin')->user()->status_admin == 0){
			$indivariabel = IndikatorVariabel::where('status', 1)->orderBy('kode_variabel', 'ASC')->paginate(10);

			return view('Dashboard::pages.master.list-indikator-variabel', ['indivariabel' => $indivariabel]);
		}else{
			return redirect('/dashboard');
		}
	}

	public function listindiopsi(){
		if(auth()->guard('admin')->user()->status_admin == 0 ){

			$indiopsi = OpsiIndikator::where('status', 1)->orderBy('kode_variabel','ASC')->orderBy('no_opsi','ASC')->paginate(10);

			return view('Dashboard::pages.master.list-opsi-indikator', ['indiopsi' => $indiopsi]);
		}else{
			return redirect('/dashboard');
		}
	}

	public function indiopsi(){
		if(auth()->guard('admin')->user()->status_admin == 0){
			$indi = IndikatorVariabel::where('caraisi', '2')->orWhere('caraisi', '3')->where('status', 1)->orderBy('kode_variabel','ASC')->get();
			return view('Dashboard::pages.master.opsi-indikator', ['indi' => $indi]);
		}else{
			return redirect('/dashboard');
		}
	}

	public function postindiopsi(Request $request){
		if($request->get('sub_opsi') == '1'){
			$getopsi = OpsiIndikator::where('kode_variabel', $request->get('kode'))->where('no_opsi', $request->get('no_opsi'))->where('opsi_indi', $request->get('opsi_indi'))->where('status', 1)->get();
		}else{
			$getopsi = OpsiIndikator::where('kode_variabel', $request->get('kode'))->where('no_opsi', $request->get('no_opsi'))->where('status', 1)->get();
		}
		if($getopsi->isEmpty()){
			$opsi = new OpsiIndikator;
			/*$opsi->sub_opsi = $request->get('sub_opsi');
			$opsi->kode_sub = $request->get('kode_sub');
			$opsi->nama_sub = $request->get('nama_sub');*/
			$opsi->kode_variabel = $request->get('kode');
			/*$opsi->opsi_indi = $request->get('opsi_indi');*/
			$opsi->no_opsi = (int) $request->get('no_opsi');
			$opsi->desc_opsi = $request->get('desc_opsi');
			/*$opsi->rincian = $request->get('rincian');*/
			$opsi->status = 1;
			if($opsi->save()){
				$pesan = array('success' => 1, 'message' => 'Terima kasih. Opsi indikator berhasil tersimpan.');
			}else{
				$pesan = array('success' => 0, 'message' => 'Mohon maaf. Opsi indikator gagal tersimpan.');
			}
		}else{
			$pesan = array('success' => 0, 'message' => 'Mohon maaf. No. Opsi indikator telah digunakan.');
		}

		return json_encode($pesan);
	}

	public function indiopsidelete($idopsi){
		$getopsi = OpsiIndikator::where('_id', $idopsi)->where('status', 1)->get();
		if($getopsi->isEmpty()){
			$pesan = array('success' => 0, 'message' => 'Mohon maaf. Opsi Indikator tidak ditemukan.');
		}else{
			$opsi = OpsiIndikator::where('_id', $idopsi)->where('status', 1)->update([
				'status' => 0
			]);
			if($opsi){
				$pesan = array('success' => 1, 'message' => 'Terima kasih. Opsi Indikator berhasil terhapus.');
			}else{
				$pesan = array('success' => 0, 'message' => 'Mohon maaf. Opsi Indikator gagal terhapus.');

			}
		}

		return json_encode($pesan);
	}

	public function indiopsiupdate($idopsi){
		if(auth()->guard('admin')->user()->status_admin == 0 ){
			$indi = IndikatorVariabel::where('caraisi', '2')->where('status', 1)->get();
			$opsiindi = OpsiIndikator::where('_id', $idopsi)->where('status', 1)->get();
			$opsi = OpsiIndikator::where('kode_variabel', $opsiindi[0]->kode_variabel)->where('opsi_indi', '')->where('status', 1)->get();

			return view('Dashboard::pages.master.opsi-indikator-update', ['indi' => $indi, 'opsiindi' => $opsiindi, 'opsi' => $opsi]);
		}else{
			return redirect('/dashboard');
		}
	}

	public function indiopsipostupdate(Request $request){
		$getindi = OpsiIndikator::where('_id', $request->get('id_opsi'))->where('status', 1)->get();

		if($getindi->isEmpty()){
			$pesan = array('success' => 0, 'message' => 'Mohon maaf. Opsi Indikator tidak ditemukan');
		}else{
			$getopsi = OpsiIndikator::where('kode_variabel', $request->get('kode'))->where('no_opsi', $request->get('no_opsi'))->where('status', 1)->get();

			if(!$getopsi->isEmpty()){
				if($getopsi[0]->_id == $request->get('id_opsi')){
					$indi = OpsiIndikator::where('_id', $request->get('id_opsi'))->where('status', 1)->first();
					$indi->kode_variabel = $request->get('kode');
					$indi->no_opsi = (int) $request->get('no_opsi');
					$indi->desc_opsi = $request->get('desc_opsi');

					if($indi->save()){
						$pesan = array('success' => 1, 'message' => 'Terima kasih. Opsi indikator berhasil disunting.');
					}else{
						$pesan = array('success' => 0, 'message' => 'Mohon maaf. Opsi indikator gagal disunting.');
					}
				}else{
					$pesan = array('success' => 0, 'message' => 'Mohon maaf. No. Opsi indikator telah digunakan.');
				}
			}else{
				$indi = OpsiIndikator::where('_id', $request->get('id_opsi'))->where('status', 1)->first();
				$indi->kode_variabel = $request->get('kode');
				$indi->no_opsi = (int) $request->get('no_opsi');
				$indi->desc_opsi = $request->get('desc_opsi');

				if($indi->save()){
					$pesan = array('success' => 1, 'message' => 'Terima kasih. Opsi indikator berhasil disunting.');
				}else{
					$pesan = array('success' => 0, 'message' => 'Mohon maaf. Opsi indikator gagal disunting.');
				}
			}
		}

		return json_encode($pesan);
	}

	public function getopsiindi($idvar){
		$opsi = OpsiIndikator::where('kode_variabel', $idvar)->where('opsi_indi', '')->where('status', 1)->get();

		return json_encode($opsi);
	}

	//master opd
	
	/**
	 * route : /master/opd
	 *
	 * @method get opdIndex()
	 * 
	 * @return void
	 */
	public function opdIndex()
	{
		if ($this->authCheck()) {
			$skpd = Skpd::where('status', 1)->paginate(10);

			return view('Dashboard::pages.master.opd.index')
				->withSkpd($skpd)
				->withTitle("Daftar OPD");
		} else {
			return redirect('/dashboard');
		}
	}

	/**
	 * route => /master/input
	 * 
	 * @method get opdCreate()
	 */
	public function opdCreate()
	{
		if ($this->authCheck()) {
			return view('Dashboard::pages.master.opd.create')->withTitle('Tambah Data OPD');
		} else {
			return redirect('/dashboard');
		}
	}

	/**
	 * route => /master/input
	 *
	 * @method post opdSave()
	 * 
	 * @return void
	 */
	public function opdSave(Request $request)
	{
		$lastSkpdKode = Skpd::where('status', 1)->orderBy('kode', 'DESC')->get();
		if ($lastSkpdKode->isEmpty()) {
			$kode = 's001';
		} else {
			$getKode = substr($lastSkpdKode[0]->kode, 1);
			$kode = 's'.str_pad((int)$getKode + 1, 3, '0', STR_PAD_LEFT);
		}

		$newSkpd = new Skpd;
		$newSkpd->kode = $kode;
		$newSkpd->name = $request->name_opd;
		$newSkpd->status = 1;

		if ($newSkpd->save()) {
			$pesan = array('success' => 1, 'message' => 'Data Skpd berhasil disimpan');
		} else {
			$pesan = array('success' => 0, 'message' => 'Data Skpd gagal disimpan');
		}

		return json_encode($pesan);
	}

	/** 
	 * Route => /master/update/{idOpd}
	 * 
	 * @method get opdEdit()
	 * 
	*/
	public function opdEdit($idOpd)
	{
		if ($this->authCheck()) {
			$thisSkpd = Skpd::where('_id', $idOpd)->where('status', 1)->get();
			
			return view('Dashboard::pages.master.opd.edit')
				->withSkpd($thisSkpd[0])
				->withTitle("Edit Data OPD");
		}
	}

	/**
	 * Route => /master/update
	 * 
	 * @method post opdUpdate()
	 */
	public function opdUpdate(Request $request)
	{
		$thisSkpd = Skpd::where('_id', $request->get('idOpd'))->where('status', 1)->first();

		if (!$thisSkpd) {
			//not found id
			$pesan = array('success' => 0, 'message' => 'Mohon maaf, Data tidak ditemukan');
		} else {
			$thisSkpd->name = $request->get('name_opd');

			if ($thisSkpd->save()) {
				//success
				$pesan = array('success' => 1, 'message' => 'Terima kasih. Data berhasil diperbaharui');
			} else {
				$pesan = array('success' => 0, 'message' => 'Terima kasih. Data gagal diperbaharui');
			}
		}

		return json_encode($pesan);
	}

	/**
	 * Route => /master/delete/{idOpd}
	 * 
	 * @method get opdDelete()
	 */
	public function opdDelete($idOpd)
	{
		$thisSkpd = Skpd::where('_id', $idOpd)->where('status', 1)->first();

		if (!$thisSkpd) {
			//not found id
			$pesan = array('success' => 0, 'message' => 'Mohon maaf, Data tidak ditemukan');
		} else {
			$thisSkpd->status = 0;

			if ($thisSkpd->save()) {
				//success
				$pesan = array('success' => 1, 'message' => 'Terima kasih. Data berhasil dihapus');
			} else {
				$pesan = array('success' => 0, 'message' => 'Terima kasih. Data gagal dihapus');
			}
		}

		return json_encode($pesan);
	}

	public function authCheck()
	{
		return (auth()->guard('admin')->user()->status_admin == 0) ? true : false;
	}
}
