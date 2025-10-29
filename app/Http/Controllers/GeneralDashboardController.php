<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralDashboardController extends Controller
{
    /**
     * Halaman utama dashboard
     */

    
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'General Dahboard',
            'list' => ['Home', 'General Dahboard']
        ];

        $page = (object)[
            'title' => 'General Dahboard'
        ];

        $activeMenu = 'General Dahboard';

        return view('dashboard.index', compact('breadcrumb', 'page', 'activeMenu'));
    }
}