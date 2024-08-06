<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

if (!function_exists('jsonRedirect')) {
    function jsonRedirect(string $route, string $message = ''): JsonResponse
    {
        Session::flash('flash_message', $message);
        return response()->json(['redirect' => route($route)]);
    }
}

if (!function_exists('jsonTable')) {
    function jsonTable(array $data, string $message = ''): JsonResponse
    {
        return response()->json([
            'tableId' => $data['tableId'] ?? '',
            'modalId' => $data['modalId'] ?? '',
            'message' => $message ?? '',
        ]);
    }
}

if (!function_exists('getFileStorageUrl')) {
    function getFileStorageUrl(string $path = null, string $default): string
    {
        if ($path) {
            return Storage::disk('public')->exists($path) ? Storage::url($path) : asset($default);
        } else {
            return asset($default);
        }
    }
}

if (!function_exists('getIconTrueFalse')) {
    function getIconTrueFalse(bool $value): string
    {
        return $value ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>';
    }
}
