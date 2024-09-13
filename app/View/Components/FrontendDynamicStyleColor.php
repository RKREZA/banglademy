<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class FrontendDynamicStyleColor extends Component
{

    public function render()
    {
        $color = Cache::rememberForever('color_theme', function () {
            return DB::table('themes')
                ->select(
                    'theme_customizes.primary_color',
                    'theme_customizes.secondary_color',
                    'theme_customizes.footer_background_color',
                    'theme_customizes.footer_headline_color',
                    'theme_customizes.footer_text_color',
                    'theme_customizes.footer_text_hover_color',
                )
                ->join('theme_customizes', 'themes.id', '=', 'theme_customizes.theme_id')
                ->where('themes.is_active', '=', 1)
                ->where('theme_customizes.is_default', '=', 1)
                ->first();
        });
        return view(theme('components.frontend-dynamic-style-color'), compact('color'));
    }
}
