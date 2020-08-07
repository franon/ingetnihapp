<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CABeritaController extends AdminController
{
    public function berita(){
        $headers = parent::getToken();
        $dataBerita = parent::callAPI("GET", "localhost:8000/api/get/berita/allberita", false, $headers);
        $dataBerita = json_decode($dataBerita);
        // dd($dataBerita);
        $dataBerita = $dataBerita->data;
        return view('admin.config-jadwal.berita.index', ['dataBerita'=>$dataBerita]);
    }
}
