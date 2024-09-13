<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Session;
use Illuminate\View\Component;
class PopupContent extends Component
{

    public function render()
    {
        $popup = \Modules\PopupContent\Entities\PopupContent::getData();
        $modal = false;
        if ($popup->status == 1) {
            if (Session::get('ip') == null) {
                Session::put('ip', request()->ip());
                $modal = true;
            }
        }


        return view(theme('components.popup-content'), compact('popup', 'modal'));
    }
}
