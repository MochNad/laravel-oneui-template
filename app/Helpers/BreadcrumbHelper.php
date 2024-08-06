<?php

use Illuminate\Support\Facades\Request;

class BreadCrumbHelper
{
    public static function getBreadcrumb(): array
    {
        $path = Request::path();
        $segments = explode('/', $path);
        $count = count($segments);
        $breadcrumb = [
            'first' => '',
            'second_last' => '',
            'last' => '',
            'all' => [],
        ];

        $currentUrl = '';
        foreach ($segments as $segment) {
            $currentUrl .= '/' . $segment;
            $breadcrumb['all'][] = [
                'name' => self::formatSegment($segment),
                'url' => url($currentUrl),
            ];
        }
        $breadcrumb['first'] = self::formatSegment($segments[0]);
        $breadcrumb['last'] = self::formatSegment($segments[$count - 1]);

        if ($count > 2) {
            $breadcrumb['second_last'] = self::formatSegment($segments[$count - 2]);
        } else {
            $breadcrumb['second_last'] = $breadcrumb['last'];
        }

        return $breadcrumb;
    }
    private static function formatSegment(string $segment): string
    {
        return ucwords(str_replace(['-', '_'], ' ', $segment));
    }
}
