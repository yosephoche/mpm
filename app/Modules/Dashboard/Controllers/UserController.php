<?php

namespace App\Modules\Dashboard\Controllers;

use Illuminate\Http\Request;
use App\Models\UserStatus;
use App\Models\Users;
use App\Models\Kecamatan;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Hash;

class UserController extends Controller
{
    public function index(){
        if(auth()->guard('admin')->user()->status_admin == 0 || auth()->guard('admin')->user()->status_admin == 1){
    		$kecamatan = Kecamatan::where('id_kota', '7316')->where('status', true)->get();
            $userstatus = UserStatus::where('status', 1)->get();

        	return view('Dashboard::pages.user.index', ['userstatus' => $userstatus, 'kecamatan' => $kecamatan]);
        }else{
            return redirect('/dashboard');
        }
    }

    public function listpengguna(){
        if(auth()->guard('admin')->user()->status_admin == 0 || auth()->guard('admin')->user()->status_admin == 1){

            if(auth()->guard('admin')->user()->status_admin == '0'){
                $getuser = Users::where('status', 1)->paginate(10);        
            }else{
                $getuser = Users::where('status_admin', '<>', '0')->where('status', 1)->paginate(10);        

            }

            return view('Dashboard::pages.user.list-user', ['user' => $getuser]);
        }else{
            return redirect('/dashboard');
        }
    }

    public function registrasi(Request $request){
        $getuser = Users::where('email', $request->get('email'))->where('status', 1)->get();

        if($getuser->isEmpty()){
            $user = new Users;
            $user->fullname = $request->get('nama_lengkap');
            $user->email = $request->get('email');
            $user->password = Hash::make($request->get('password'));
            $user->kontak = $request->get('kontak');
            $user->status_admin = $request->get('status');
            if($request->get('status') == '2'){
                $user->kec = $request->get('kec');
            }
            $user->status = 1;

            if($user->save()){
                $pesan = array('success' => 1, 'message' => 'Pengguna berhasil ditambahkan.');
            }else{
                $pesan = array('success' => 0, 'message' => 'Pengguna gagal ditambahkan.');
            }
        }else{
            $pesan = array('success' => 0, 'message' => 'Email telah terdaftar.');
        }

        return json_encode($pesan);
    }

    public function delete($iduser){
        $getuser = Users::where('_id', $iduser)->where('status', 1)->get();
        if($getuser->isEmpty()){
            $pesan = array('success' => 0, 'message' => 'Pengguna tidak ditemukan');
        }else{
            $user = Users::where('_id', $iduser)->where('status', 1)->update([
                'status' => 0
            ]);
            if($user){
                $pesan = array('success' => 1, 'message' => 'Pengguna berhasil dihapus');
            }else{
                $pesan = array('success' => 0, 'message' => 'Pengguna gagal dihapus');
            }
        }

        return json_encode($pesan);
    }

    public function update($iduser){
        if(auth()->guard('admin')->user()->status_admin == 0 || auth()->guard('admin')->user()->status_admin == 1){
            $users = Users::where('_id', $iduser)->where('status', 1)->get();
            $userstatus = UserStatus::where('status', 1)->get();
    		$kecamatan = Kecamatan::where('id_kota', '7316')->where('status', true)->get();

            return view('Dashboard::pages.user.update', ['users' => $users, 'userstatus' => $userstatus, 'kecamatan'=>$kecamatan]);
        }else{
            return redirect('/dashboard');

        }
    }

    public function postupdate(Request $request){
        $getuser = Users::where('_id', $request->get('iduser'))->where('status', 1)->get();

        if($getuser->isEmpty()){
            $pesan = array('success' => 0, 'message' => 'Pengguna tidak ditemukan');
        }else{
            $getemail = Users::where('email', $request->get('email'))->where('status', 1)->get();
            if($getemail->isEmpty()){
                if($request->get('status') == '2'){
                    $email = Users::where('_id', $request->get('iduser'))->where('status', 1)->update([
                        'fullname' => $request->get('nama_lengkap'),
                        'email' => $request->get('email'),
                        'kontak' => $request->get('kontak'),
                        'kec' => $request->get('kec'),
                        'status_admin' => $request->get('status')
                    ]);
                }else{
                    $email = Users::where('_id', $request->get('iduser'))->where('status', 1)->update([
                        'fullname' => $request->get('nama_lengkap'),
                        'email' => $request->get('email'),
                        'kontak' => $request->get('kontak'),
                        'status_admin' => $request->get('status')
                    ]);
                }

                if($email){
                    $pesan = array('success' => 1, 'message' => 'Pengguna berhasil disunting.');
                }else{
                    $pesan = array('success' => 0, 'message' => 'Pengguna gagal disunting.');
                }
            }else{
                if($getemail[0]->_id == $request->get('iduser')){
                    if($request->get('status') == '2'){

                        $email = Users::where('_id', $request->get('iduser'))->where('status', 1)->update([
                            'fullname' => $request->get('nama_lengkap'),
                            'email' => $request->get('email'),
                            'kontak' => $request->get('kontak'),
                            'kec' => $request->get('kec'),
                            'status_admin' => $request->get('status')
                        ]);
                    }else{
                        $email = Users::where('_id', $request->get('iduser'))->where('status', 1)->update([
                            'fullname' => $request->get('nama_lengkap'),
                            'email' => $request->get('email'),
                            'kontak' => $request->get('kontak'),
                            'status_admin' => $request->get('status')
                        ]);
                    }
                    if($email){
                        $pesan = array('success' => 1, 'message' => 'Pengguna berhasil disunting.');
                    }else{
                        $pesan = array('success' => 0, 'message' => 'Pengguna gagal disunting.');
                    }
                }else{
                    $pesan = array('success' => 0, 'message' => 'Email sudah digunakan.');
                }
            }
        }
        return json_encode($pesan);
    }

    public function updatepassword(Request $request){
        $getuser = Users::where('_id', $request->get('iduser'))->where('status', 1)->get();

        if($getuser->isEmpty()){
            $pesan = array('success' => 0, 'message' => 'Pengguna tidak ditemukan.');
        }else{
            $user = Users::where('_id', $request->get('iduser'))->where('status', 1)->update([
                'password' => Hash::make($request->get('password'))
            ]);
            if($user){
                $pesan = array('success' => 1, 'message' => 'Kata sandi pengguna berhasil disunting.');
            }else{
                $pesan = array('success' => 0, 'message' => 'Kata sandi pengguna gagal disunting.');
            }
        }

        return json_encode($pesan);
    }

    public function pengaturanpengguna(){
            $getuser = Users::where('_id', auth()->guard('admin')->user()->_id)->where('status', 1)->get();

            return view('Dashboard::pages.user.pengaturan-akun', ['user' => $getuser]);

    }

    public function postpengaturanpengguna(Request $request){
        $getuser = Users::where('_id', $request->get('iduser'))->where('status', 1)->get();

        if($getuser->isEmpty()){
            $pesan = array('success' => 0, 'message' => 'Pengguna tidak ditemukan');
        }else{
            $getemail = Users::where('email', $request->get('email'))->where('status', 1)->get();
            if($getemail->isEmpty()){
                $email = Users::where('_id', $request->get('iduser'))->where('status', 1)->update([
                    'fullname' => $request->get('nama_lengkap'),
                    'email' => $request->get('email'),
                    'kontak' => $request->get('kontak'),
                ]);
                if($email){
                    $pesan = array('success' => 1, 'message' => 'Pengguna berhasil disunting.');
                }else{
                    $pesan = array('success' => 0, 'message' => 'Pengguna gagal disunting.');
                }
            }else{
                if($getemail[0]->_id == $request->get('iduser')){
                    $email = Users::where('_id', $request->get('iduser'))->where('status', 1)->update([
                        'fullname' => $request->get('nama_lengkap'),
                        'email' => $request->get('email'),
                        'kontak' => $request->get('kontak'),
                    ]);
                    if($email){
                        $pesan = array('success' => 1, 'message' => 'Pengguna berhasil disunting.');
                    }else{
                        $pesan = array('success' => 0, 'message' => 'Pengguna gagal disunting.');
                    }
                }else{
                    $pesan = array('success' => 0, 'message' => 'Email sudah digunakan.');
                }
            }
        }
        
        return json_encode($pesan);
    }
}
