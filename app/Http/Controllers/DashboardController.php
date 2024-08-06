<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    protected $modules = ["dashboard"];

    public function index()
    {
        $role = auth()->user()->getRoleNames()->first();
        $viewPath = 'pages.dashboard.' . strtolower($role) . '.index';

        if (view()->exists($viewPath)) {
            return view($viewPath);
        }

        return $this->viewDefault();
    }

    private function viewDefault()
    {
        return view('pages.dashboard.default.index');
    }
}
