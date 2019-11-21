<?php

namespace Genericmilk\Rollout;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class Rollout extends Controller
{

    protected static $url = null;
    protected static $headers = [];
    protected static $body = [];
    

    public static function call($url){
        Rollout::$url = $url; // Add url to top
        $o = new self;
        return $o;
    }

    public static function headers($header){
        Rollout::$headers = $header; // Add headers to top
        $o = new self;
        return $o;

    }    
    public static function body($body){
        Rollout::$body = $body; // Add body to top
        $o = new self;
        return $o;
    }
    public static function bearer($bearer){
        Rollout::$headers[] = 'Authorization: Bearer '.$bearer;
        $o = new self;
        return $o;
    }
    public static function auth($user,$pass){
        $combined = base64_encode($user.':'.$pass);
        Rollout::$headers[] = 'Authorization: Basic '.$combined;
        $o = new self;
        return $o;
    }
    
    

    public static function get(){

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => Rollout::$url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => Rollout::$headers
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if (!$err) {
            $response = json_decode($response);
            $response = json_decode(json_encode($response)); // force convert to php object
            return $response;
        } else {
            throw new \Exception('Rollout dropped call; '.$err);
        }
    }

    private function build_post_fields( $data,$existingKeys='',&$returnArray=[]){
        if(($data instanceof CURLFile) or !(is_array($data) or is_object($data))){
            $returnArray[$existingKeys]=$data;
            return $returnArray;
        }
        else{
            foreach ($data as $key => $item) {
                $this->build_post_fields($item,$existingKeys?$existingKeys."[$key]":$key,$returnArray);
            }
            return $returnArray;
        }
    }

    public function post(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => Rollout::$url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $this->build_post_fields(Rollout::$body),
          CURLOPT_HTTPHEADER => Rollout::$headers,
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if (!$err) {
            $response = json_decode($response);
            $response = json_decode(json_encode($response)); // force convert to php object
            return $response;
        } else {
            throw new \Exception('Rollout dropped call; '.$err);
        }
    }
}