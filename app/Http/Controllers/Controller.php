<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function contacts() {
        return DB::table('lookups')->where('lookup_parent', 70)->get();
    }

    public function coin_types() {
        return DB::table('lookups')->where('lookup_parent', 85)->get();
    }

    public function lookup_title($id) {

        return DB::table('lookups')->where('lookup_id', $id)->first();
    }

    public function accountToData($result , $from , $to) {
        $result = $result->map(function ($value) {
            $value['account'] = $value->donation2->sum('price');
            return $value;
        });

        $result = $result->where('account' , '>=' , !empty($from) && is_numeric($from) ? $from :$result->min('account'))
                         ->where('account' , '<=' ,!empty($to) && is_numeric($to) ? $to :$result->max('account'));

        return $result;
    }


}
