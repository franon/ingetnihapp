<?php

namespace App\Http\Controllers;

use App\Craw;
use Carbon\Carbon;
use DOMDocument;
use Exception;
use Goutte\Client;

use Illuminate\Http\Request;
use Goutte\Client as GoutteClient;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
// use simple_html_dom;

include(public_path().'/../vendor/simplehtmldom-1.9.1/simple_html_dom.php');

class CrawBaak_copy extends Controller
{
    public $berita= [];
    // public function crawNow(){
    //     $depth = 5;
    //     $root = "http://baak.budiluhur.ac.id";
    //     $html = file_get_html($root);
    //     foreach ($html->find('#menu-main-slide ul li a') as $category){
    //         echo $depth;
    //         if($depth == 1){
    //             $depth = 5;
    //             echo "wow";
    //         }else{
    //             $depth--;
    //         }

    //     }
    // }
    public function crawNow(){
        $html = file_get_html('http://baak.budiluhur.ac.id');
        global $berita;
        $depth=2;
        foreach($html->find('#menu-main-slide ul li a') as $category){
            // die;
            if($category->plaintext == "Cuti") continue;
            
            $berita[$category->plaintext] = $category->href;
            $berita[$category->plaintext] = self::CrawNow2($category->href,$depth);
            
        }
        // dd($GLOBALS['berita']);
            return response()->json(["message"=> 'OK', 'data'=>$berita],200);
        // return $html;
    }
    public function crawNow2($link,$depth){
        $html = file_get_html($link.'page/'.$depth);
        global $berita;
        // dd($depth < 2);
        // if($depth < 2){
        //     echo $depth;
        //     die;
        // } 
        // $html = file_get_html('http://baak.budiluhur.ac.id/category/tugas-akhir/');
        // $berita = [];
        // var_dump($berita);
        if($depth == 0){
            // dd($depth,$berita);
            return;
        }else{
            $count = 0;
            foreach($html->find('.recent-posts article') as $article){
                $link = $article->find('section header h3 a',0)->href;
                $judul = $article->find('section header h3 a',0)->plaintext;
                if($link == null){
                    continue;
                }
                $content = self::scrapContent($link);
                $berita[$article->id]['post_id'] = $article->id;
                $berita[$article->id]['link'] = $link;
                $berita[$article->id]['judul'] = $judul;
                $berita[$article->id]['isi'] = $content['isi'];
                $berita[$article->id]['img'] = $content['img'];
                $berita[$article->id]['date'] = $content['date'];
                $GLOBALS['berita'] = $berita;
                

            }
        self::crawNow2($link, --$depth);
        }
        
        // echo (json_encode($berita));
        // return response()->json(["status"=>200, "message" => "crawl data", "data"=>$berita],200);
        // return $berita;
        
    }

    public function penampungan($berita){
        $data[] = $berita;
    }

    public function crawNowHide(){
        $html = file_get_html('http://baak.budiluhur.ac.id/category/pengumuman/');

        $count = 0;
        $berita = [];
        foreach($html->find('.recent-posts article') as $article){
            $link = $article->children(1)->children(0)->children(0)->children(0)->href;
            $judul = $article->children(1)->children(0)->children(0)->plaintext;
            if($link == null){
                continue;
            }
            $content = self::scrapContent($link);
            $berita[$article->id]['post_id'] = $article->id;
            $berita[$article->id]['link'] = $link;
            $berita[$article->id]['judul'] = $judul;
            $berita[$article->id]['isi'] = $content['isi'];
            $berita[$article->id]['img'] = $content['img'];
            $berita[$article->id]['date'] = $content['date'];
        }
        
        // echo (json_encode($berita));
        // return response()->json(["status"=>200, "message" => "crawl data", "data"=>$berita],200);
        return $berita;
        
    }
    
    public function scrapContent($link){
        $html = file_get_html($link);

        $datax = [
            "isi" => "",
            "img" => "",
            "date"=>""
        ];
        $count = 0;
        foreach ($html->find('.post-wrap article') as $element){
            $elemetDate = $element->find('aside[class="entry-date"]',0);
            foreach($elemetDate->children() as $date){
                $datax["date"] .= $date->plaintext.' ';
            }
            $elemetIsi = $element->find('section div[class=entry-content]',0);
            foreach( $elemetIsi->children() as $articleContent){
                if($articleContent->tag == 'p'){
                    $datax["isi"] .= $articleContent;
                    if(isset($articleContent->children(0)->href) && self::isImage($articleContent->children(0)->href)){
                        $datax['img'] = $articleContent->children(0)->href;
                    }
                }
            }
        }
        
        $datax["date"] = Carbon::parse($datax["date"])->toDateString();
        return $datax;
    }

    public function isImage($url){
        $contentType = get_headers($url,1)["Content-Type"];
        if(isset($contentType)){
            if(is_array($contentType)){
                $result = strpos($contentType[1],'image');
            }else{
                $result = strpos($contentType,'image');
            }
        }else{
            $result = false;
        }

        if($result !== false) return true;

        return false;
    }

    public function insertIntoDatabase(){
        $dataBerita = self::crawNowHide();
        foreach($dataBerita as $data){
            $berita = [
                "berita_id"=> $data["post_id"],
                "berita_link"=> base64_encode($data["link"]),
                "berita_judul"=> $data["judul"],
                "berita_isi"=> base64_encode($data["isi"]),
                "gambar_link"=> base64_encode($data["img"]),
                "berita_tanggal"=> $data["date"],
            ];
            Craw::updateOrInsert($berita);
        }

        return response()->json(["status"=>200, "message"=>"Crawling Done!...", "data"=>$dataBerita],200);
    }

    public function downloadFile(){
        $url = 'http://baak.budiluhur.ac.id/2020/06/kalender-akademik-gasal-20202021/sk-rektor-tentang-kalender-akademik-ta-gasal-2020-2021_24-juni-2020_kalender-akademik-gasal-2020-2021-final-2/';
        $filename = 'KAdemik.pdf';
        $path = Storage::disk('pdf')->put($filename, $url);
        echo $path;
    }

    public function isPdf(){
        $contentType = get_headers($this->urlPdfNonArray,1)['Content-Type'];
        if(strpos($contentType, 'pdf') == TRUE){
            if(is_array($contentType)){
                $pdf = strpos($contentType[1], 'pdf');
            }else{
                $pdf = strpos($contentType, 'pdf');
            }
        }else{
            echo "not pdf";
        }
        // if($pdf !== false) return true;


        // return false;
    }
}
