<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }
    public function data_siswa(){
        return view('admin.data_siswa');
    }
    public function kelas(){
        return view('admin.kelas');
    }
}
