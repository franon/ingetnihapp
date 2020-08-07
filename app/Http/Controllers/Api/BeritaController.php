<?php

namespace App\Http\Controllers\Api;

use App\Berita;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BeritaController extends Controller
{

    public function showSpesifikBerita($berita_id){
        try {
            $berita = Berita::where('berita_id',$berita_id)->first();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return response()->json(["status"=>200,"message"=>"Berhasil mendapatkan berita!", "data"=>$berita],200);
    }

    public function showAllBerita(){
        try {
            $berita = Berita::all();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return response()->json(["status"=>200,"message"=>"Berhasil mendapatkan semua berita!", "data"=>$berita],200);
    }
    
    public function getAllBeritaDT(){
        $berita = Berita::all();
        return Datatables::of($berita)
                            ->addColumn("action", function($news){
                                return '
                                <td> 
                                <a href="/admin/news/edit/'.$news->berita_id.'" class="btn btn-outline-info mb-3"><i class="fa fa-pencil" aria-hidden="true">edit</i></a> |
                                <a href="/admin/news/delete/'.$news->berita_id.'" class="btn btn-outline-info mb-3"><i class="fa-ban"></i> remove</a>
                                </td>';
                            })
                            ->make(true);
    }

}
