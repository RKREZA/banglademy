<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class FooterSocialLinks extends Component
{

    public function render()
    {
        $social_links = Cache::rememberForever('social_links', function () {
            return DB::table('social_links')
                ->select('link', 'icon', 'name')
                ->where('status', '=', 1)
                ->get();
        });
        return view(theme('components.footer-social-links'), compact('social_links'));
    }
}
