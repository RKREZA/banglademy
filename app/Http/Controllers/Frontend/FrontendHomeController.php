<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;


class FrontendHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenanceMode');
    }

    public function index()
    {
        try {
            $blocks = json_decode(HomeContents('homepage_block_positions'));
            $homeContent =  app('getHomeContent');
            return view(theme('pages.index'), compact('blocks', 'homeContent'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);

        }
    }
}
