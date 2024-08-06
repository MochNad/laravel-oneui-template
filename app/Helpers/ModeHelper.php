<?php

use Illuminate\Support\Facades\Cookie;

class ModeHelper
{
    public static function getMode(): array
    {
        $cookie = Cookie::get('mode', 'light');
        $mode = ['auth' => '', 'dashboard' => ''];
        if ($cookie == 'dark') {
            $mode['auth'] = 'dark-mode';
            $mode['dashboard'] = 'sidebar-dark page-header-dark dark-mode';
        }
        return $mode;
    }
}
