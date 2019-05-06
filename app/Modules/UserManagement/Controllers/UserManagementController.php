<?php

namespace App\Modules\UserManagement\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Hash;
use Session;
use Mail;

class UserManagementController extends Controller
{
    public function index(){
        if(!empty(auth()->guard('admin')->user()->email)){
            return redirect('/dashboard');
        }else{
            return view('UserManagement::pages.index');
        }
    }

    public function login(Request $request){
    	$getemail = Users::where('email', $request->get('email'))->where('status', 1)->get();
    	$credential = ['email' => $request->get('email'), 'password' => $request->get('password'), 'status' => 1];

        Session::flash('getemail', $request->get('email'));
    	if($getemail->isEmpty()){
    		Session::flash('email', '<b>Maaf</b>, Email tidak dikenali!');
    		return redirect('/globallogin');
    	}elseif(auth()->guard('admin')->attempt($credential)){
    		return redirect('/dashboard');
    	}else{
    		Session::flash('password', '<b>Maaf</b>, Kata sandi tidak sesuai!');
    		return redirect('/globallogin');
    	}
    }

    public function sendemailforgot(Request $request){
        $getemail = Users::where('email', $request->get('email'))->where('status', 1)->get();
        if($getemail->isEmpty()){
            $pesan = array('success' => 0, 'message' => 'Email pengguna tidak ditemukan');
        }else{
            $token = urlencode(md5(date('Ymd').$request->get('email')));
            
            $emailSend = Mail::send('UserManagement::pages.email',['url' => URL('/reset-password').'/'.$getemail[0]->_id.'/'.$token], function($message) use ($getemail){
                $message->to($getemail[0]->email, $getemail[0]->fullname)->subject('Reset Sandi Sipakatau');
            });
            if($emailSend){
                $pesan = array('success' => 1, 'message' => 'Email reset sandi berhasil terkirim');
            }else{
                $pesan = array('success' => 0, 'message' => 'Email reset sandi gagal terkirim');
            }
        }

        return json_encode($pesan);
    }

    public function resetpassword($id, $token){
        $getuser = Users::where('_id', $id)->where('status', 1)->get();

        if($getuser->isEmpty()){
            return view('Front::pages.error', ['code' => '404', 'message' => 'Maaf, Halaman Tidak Ditemukan']);
        }else{
            $gettoken = urlencode(md5(date('Ymd').$getuser[0]->email));
            if($token == $gettoken){
                return view('UserManagement::pages.reset', ['user' => $getuser]);
            }else{
                return view('Front::pages.error', ['code' => '404', 'message' => 'Maaf, Halaman Tidak Ditemukan']);
            }
        }
    }

    public function postresetpassword(Request $request){
        $getuser = Users::where('_id', $request->get('id'))->where('status', 1)->get();

        if($getuser->isEmpty()){
            $pesan = array('success' => 0, 'message' => 'Pengguna tidak dapat ditemukan');
        }else{
            $upduser = Users::where('_id', $request->get('id'))->where('status', 1)->update([
                'password' => Hash::make($request->get('password'))
            ]);

            if($upduser){
                $pesan = array('success' => 1, 'message' => 'Kata sandi berhasil diubah');
            }else{
                $pesan = array('success' => 0, 'message' => 'Kata sandi gagal diubah');
            }
        }

        return json_encode($pesan);
    }

    public function logout(){
    	auth()->guard('admin')->logout();
		return redirect('/globallogin');
    }
}
