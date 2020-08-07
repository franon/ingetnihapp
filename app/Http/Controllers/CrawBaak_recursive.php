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

class CrawBaak_recursive extends Controller
{
    // public function suv1($link){
    //     self::Scrapping($link);

    // }

    // public function Scrapping($link){
        
    // }


    







































    

    public function isURLAvailable($link){
        if(!filter_var($link, FILTER_VALIDATE_URL)){
            return false;
        }else{
            return true;
        }
    }

    public function crawl(){
        $html = file_get_html('http://baak.budiluhur.ac.id/category/pengumuman/');
        foreach($html->find('a') as $link){
            echo $link->href.'<hr>';
            // echo $link->find('section header h3 a',0)->href;
            // dd($link);
        }
    }

    public function crawlz($link,$parent='null', $rules='a' ,$level=0){
        $node = [];
        if(substr($link,0,7) != 'http://'){
            $link = 'http://'.$link;
        }
        $html = file_get_html($link);
        $visited[$link] = true;// tandai link sudah tervisit

        foreach($html->find($rules) as $link){
            if(self::isURLAvailable($link->href)!= true) continue; //URLnya valid gak?

            if(empty($visited($link->href))){ //Jika link belom tervisit

                $passed[$link->href] = true; //tandai link sudah dilewati

                if(strstr($link->href, 'category')){ //Jika Link ini merupakan category
                    $category = strstr($link->href, 'category');
                    $node[$category] = $link->href; // Category/Pengumuman = baak.budiluhur.ac.id/category/pengumuman.
                        // self::crawl($link->href, $category, $rules = '.recent-posts article'); //makan
                    $node[strstr($link->href, 'category')]['article'][] = "wow"; // masuk data kumpulan article ke variable ini. Category/Pengumuman = [article1,article2];

                }else{ //Link ini bukan Category
                    $patternArticle = "/\d{4}\/\d{2}/";
                    if(preg_match($patternArticle,$link->href,$article)){ // Jika link ini Article
                        
                    }

                }
            }else{ //jika sudah tervisit

            }
            echo 'level'.$level;
            echo $link->href.'<hr>';

        }
    }

    public function contain_Category($element){
        // $html = file_get_html($link);
        $category = !empty($element->find("#menu-main-slide ul li a"));
        if($category != false) return true;
        return false;
    }

    public function contain_Article($link){
        $html = file_get_html($link);
        $article = !empty($html->find(".recent-posts article"));
        // dd($html->find(".recent-posts article"));
        if($article != false) return true;
        return false;
    }

    public function recursive($link){
        $html = file_get_html($link);
        echo $html;

    }


    public function crawNow(){
        $html = file_get_html('http://baak.budiluhur.ac.id');
        foreach($html->find('#menu-main-slide ul li a') as $category){
            $berita[$category->plaintext] = $category->href;
            
            $berita[$category->plaintext] = self::CrawNow2($category->href);
            }
            return response()->json(["message"=> 'OK', 'data'=>$berita],200);
        // return $html;
    }
    public function crawNow2($link){
        $html = file_get_html($link);
        $count = 0;
        $berita = [];
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
        }
         return $berita;
        
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
    }

    
}
