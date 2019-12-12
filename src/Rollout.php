<?php

namespace Genericmilk\Rollout;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

use Carbon\Carbon;

class Rollout extends Controller
{

    protected static $from_str = null;
    protected static $until_str = null;

    public static function from($from = null){
        Rollout::$from_str = $from; // Add url to top
        $o = new self;
        return $o;
    }

    public static function until($until){
        Rollout::$until_str = $until; // Add url to top
        $o = new self;
        return $o;        
    }

    private function Percentage(){
        if(is_null(Rollout::$from_str) || is_null(Rollout::$until_str)){
            throw new \Exception('Incomplete rollout parameters. Both from and until need to be set in order to calculate diff.');
        }

        $fromDate = strtotime(Rollout::$from_str);
        $currentDate = time();
        $toDate = strtotime(Rollout::$until_str);

        $datediffA = round(($toDate- $fromDate) / (60 * 60 * 24));
        $datediffB =  round(($currentDate- $fromDate) / (60 * 60 * 24));
        $percentage = ($datediffB*100)/$datediffA;
        return round($percentage,2);
    }

    public function status(){
        return $this->Percentage();
    }

    public function go(){
        $max = 255255255255;
        $percentage = $this->Percentage();

        $rolloutip = $max * $percentage / 100;

        $ip = str_replace('.','',$_SERVER['REMOTE_ADDR']);

        $rolled_out = $ip <= $rolloutip ? true : false;

        return $rolled_out;
        
    }


}