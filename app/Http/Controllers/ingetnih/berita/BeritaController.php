<?php

namespace App\Http\Controllers\ingetnih\berita;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ingetnih\HomeController;
use Illuminate\Http\Request;

class BeritaController extends HomeController
{
    public function getBeritaSpesifik(Request $request){
        $berita_id= $request->berita_id;
        // dd($berita_id);
        $berita = parent::callAPI("GET", 'localhost:8000/api/get/berita/'.$berita_id,false);
        $berita = json_decode($berita);
        $berita = $berita->data;
        if(!empty(session()->get('token'))){
            $notifikasi = parent::Notifikasi();
            return view("ingetnih.berita-detail",compact(['berita','notifikasi']));
    }
    return view('ingetnih.berita-detail',compact('berita'));
}
}
