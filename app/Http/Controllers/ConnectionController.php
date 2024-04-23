<?php

namespace App\Http\Controllers;

use App\Models\ConnectionLog;
use App\Models\Server;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    //

    public static function getData() {
        $currentTime = Carbon::now();

        $data_day = ConnectionLog::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as day'),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('day')
        ->get();

        
    }


    public static function getDataHourly() {
        $currentTime = Carbon::now();

        $data_hour = ConnectionLog::select(
            DB::raw("TO_CHAR(created_at, 'YYYY-MM-DD HH24:00:00') as hour"),
            DB::raw('COUNT(*) as count'),
            'alive'
        )
        ->where('created_at', '>=', DB::raw("CURRENT_TIMESTAMP - INTERVAL '24 HOURS'"))
        ->groupBy('hour')
        ->get();

        return $data_hour;
    }

    public static function getDataMinute() {
        $data_hour = ConnectionLog::select(
            'server_id',
            DB::raw("CASE WHEN (MOD(CAST(TO_CHAR(created_at, 'MI') AS INTEGER), 2) = 1) THEN TO_CHAR(created_at - INTERVAL '1 minutes', 'YYYY-MM-DD HH24:MI') ELSE TO_CHAR(created_at, 'YYYY-MM-DD HH24:MI') END AS time"),
            DB::raw('COUNT(CASE WHEN alive = true THEN 1 END) * 100 / COUNT(*) as health'),
            DB::raw('COUNT(*) as poll'),
            
        )
        ->where('created_at', '>=', DB::raw("CURRENT_TIMESTAMP - INTERVAL '1 HOURS'"), 'AND',
                'server_id')
        ->groupBy('time', 'server_id')
        ->orderBy('time')
        ->get();
        
        $data = [];
        $server_count = Server::count();
        for ($server_id = 1; $server_id <= $server_count; $server_id++) {
            $server = Server::find($server_id);
            $data[$server->name.' | '.$server->domain] = array_values($data_hour->filter(function($v, $k) use ($server_id) {
                return $v->server_id == $server_id;
            })
            // ->only(['minute', 'health'])
            ->all());
        }

        // $data = $data_hour->groupBy(['server_id', function($item) {
        //     $server = Server::find($item['server_id']);
        //     return $server->name.' | '.$server->domain;
        // }]);
        return $data;
        dd($data);
    }
}
