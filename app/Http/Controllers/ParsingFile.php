<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Controllers\Api\EventController;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;

class ParsingFile extends EventController
{
    public function parsingFile(){
        try {
            $file = storage_path().'/pdf/kademik.pdf';
            $checkFile = file_exists($file);
            if($checkFile === false) return "Nothing to Parse!. U can relax...";

            $parser = new Parser();
            $pdf = $parser->parseFile($file);
            $textSrc = $pdf->getText();
            
            $dataParsingan = self::textValidation($textSrc);
            // return response()->json(["status"=>200, "message"=>"Fiuhh.. Now u can relax", "data"=>$dataParsingan],200);
            $result = self::insertIntoDatabase($dataParsingan);
        } catch (\Throwable $th) {
            return response()->json(["status"=>401, "message"=>$th->getMessage(), "data"=>$dataParsingan],401);
        }
        
        return response()->json(["status"=>200, "message"=>"Parsing Done!", "data"=>$dataParsingan],200);
        
        
    }

    
    
    public function textValidation($text){
        $lines = preg_split('/[\n]+/', $text);
        $data = [];
        $count = 0;

        foreach ($lines as $line){
            $line = trim($line);
            if(empty($line)){
                continue;
            }
            if(self::isTag($line)){
                $patternTag = "/\A([1-8]{1}\s+)((.(?!Awal))*)/";
                preg_match($patternTag,$line,$tag);
                $data[trim($tag[1])]["tag_id"] = trim($tag[1]);
                $data[trim($tag[1])]["tag"] = trim($tag[2]);
                $count=0;
                continue;
            }
            if(self::isRowValue($line)){
                $patternValue = '/(\d{1})\.\d{1,2}\s+([\w+\s+&?(),]+)[^\d](\d{1,2}[\s|\n]*\/\d{1,2}[\s|\n]*\/[\s|\n]*\d{2}\s?\d{2})\s*(\d{1,2}[\s|\n]*\/\d{1,2}[\s|\n]*\/[\s|\n]*\d{1}\s?\d{1}\s?\d{2}\s?)?/';
                preg_match($patternValue,$line,$value);
                $data[trim($value[1])]["data"][$count]["tag_id"] = trim($value[1]);
                $data[trim($value[1])]["data"][$count]["title"] = trim($value[2]);
                $data[trim($value[1])]["data"][$count]["date"] = self::sanitizeDate($value[3]);
                
                if(isset($value[4])){
                    $data[trim($value[1])]["data"][$count]["date_end"] = self::sanitizeDate($value[4]);
                }
                $count++;
                continue;
            }
            continue;
        }
        // echo json_encode($data);die;
        return $data;
    }
    public function sanitizeDate($date){
        $date = trim(preg_replace('/\t/','',$date));
        $date = str_replace('/', '-', $date);
        $date = date('Y-m-d', strtotime($date));
        return $date;

    }
        
    public function isRowValue($text){
        $patternRow = "/(\d{1})\.\d{1,2}\s+([\w+\s+&?(),]+)[^\d](\d{1,2}[\s|\n]*\/\d{1,2}[\s|\n]*\/[\s|\n]*\d{2}\s?\d{2})\s*(\d{1,2}[\s|\n]*\/\d{1,2}[\s|\n]*\/[\s|\n]*\d{1}\s?\d{1}\s?\d{2}\s?)?/";
        preg_match($patternRow, $text,$matches);
        // var_dump($matches);
        // var_dump($matches);
        if(!empty($matches)){
            if(is_array($matches) && isset($matches[1]) && strpos($matches[1], "7")===false){
                return true;
            }
        } 
        return false;
    }

    public function isTag($text){
        $patternTag = "/\A([1-8]{1}\s+)(.*)\b/";
        preg_match($patternTag, $text, $matches);
        if(!empty($matches)){
            if(is_array($matches) && isset($matches[2]) && strpos($matches[2], 'Pascasarjana')===false){
                return true;
            }
        } 
        return false;
    }

    public function insertIntoDatabase($data){

        foreach ($data as $tag){
            foreach($tag["data"] as $event){
                $result = parent::storeFromScrap($event);
            }
        }
        if($result !== false) return true;
        return false;
    }
}
