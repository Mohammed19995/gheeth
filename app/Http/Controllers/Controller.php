<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Broker;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        
    }

    public function contacts()
    {
        return DB::table('lookups')->where('lookup_parent', 70)->get();
    }

    public function coin_types()
    {
        return DB::table('lookups')->where('lookup_parent', 85)->get();
    }

    public function lookup_title($id)
    {

        return DB::table('lookups')->where('lookup_id', $id)->first();
    }

    public function accountToData($result, $from, $to)
    {
        $result = $result->map(function ($value) {
            $value['account'] = $value->donation2->sum('price');
            return $value;
        });

        $result = $result->where('account', '>=', !empty($from) && is_numeric($from) ? $from : $result->min('account'))
            ->where('account', '<=', !empty($to) && is_numeric($to) ? $to : $result->max('account'));

        return $result;
    }

    public static function getPermissions()
    {
        if (Auth::check()) {
            $permissions = Auth::user()->permissions->pluck('name')->toArray();
        } else {
            $permissions = [];
        }
        return $permissions;
    }

    public function getPermissions2()
    {
        if (Auth::check()) {
            $permissions = Auth::user()->permissions->pluck('name')->toArray();
        } else {
            $permissions = [];
        }
        return $permissions;
    }

    public function ifMoreThanBrokerName($brokers)
    {

        $brokerName = Broker::all()->pluck('name');
        $brokerName = $brokerName->map(function ($value) {
            $value = preg_replace('/\s+/', '', $value);
            return $value;
        })->toArray();

        $brokers = $brokers->map(function ($value) use ($brokerName) {
            $arr = array_count_values($brokerName);
            if ($arr[preg_replace('/\s+/', '', $value->name)] > 1) {
                $value->name = $value->name . " ( " . $value->alias_name . " ) ";
            }

            return $value;

        });
        return $brokers;
    }

}
