<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Sementara kita return view kosong bernama 'admin.dashboard'
        return view('admin.dashboard');
    }
}