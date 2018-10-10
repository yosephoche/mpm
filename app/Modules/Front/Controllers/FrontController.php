<?php

namespace App\Modules\Front\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FrontController extends Controller
{
	public function index(){
		return view('Front::pages.index');
	}

	public function about(){
		return view('Front::pages.about');
	}
}