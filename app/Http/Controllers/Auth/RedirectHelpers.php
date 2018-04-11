<?php

namespace App\Http\Controllers\Auth;

Trait RedirectHelpers
{
    
    public function setRefererUrlToView()
    {
        $url = request()->input('referer');
        $url = empty($url) ? route('activities.index') : urldecode($url);
        view()->share('redirect_path', $url);       
        view()->share('referer_path', '?referer='.urlencode($url));       
    }
}
