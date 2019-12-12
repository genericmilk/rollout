<?php

namespace Genericmilk\Rollout;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

use Carbon\Carbon;

class Rollout extends Controller
{

    protected static $from = null;
    protected static $until = null;

    public static function from($from){
        $from = Carbon::parse($from);
        Rollout::$from = $from; // Add url to top
        $o = new self;
        return $o;
    }

    public static function until($until){
        $until = Carbon::parse($until);
        Rollout::$until = $until; // Add url to top
        $o = new self;
        return $o;        
    }

    public static function go(){
        if(is_null(Rollout::$from) || is_null(Rollout::$until)){
            throw new \Exception('Incomplete rollout parameters. Both from and until need to be set in order to calculate diff.');
        }
        $diff = Rollout::from()->diffInDays(Rollout::until(), false);

        return $diff;
    }


}