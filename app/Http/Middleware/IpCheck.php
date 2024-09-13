<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class IpCheck
{

    public function handle($request, Closure $next)
    {


        if (!Cache::has('ipBlockList')) {
            $path = storage_path() . "/app/ip.json";
            if (file_exists($path)) {
                $ipAddresses = json_decode(file_get_contents($path), true);
                Cache::rememberForever('ipBlockList', function () use ($ipAddresses) {
                    return $ipAddresses;
                });
            }
        }
        if (Cache::get('ipBlockList')) {
            $ipAddresses = Cache::get('ipBlockList');
            if (in_array($request->ip(), $ipAddresses)) {
                abort(403, "Your Ip Blocked By Admin");
            }
        }


        return $next($request);
    }
}
