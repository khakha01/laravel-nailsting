<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the admin profile
     */
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $permissions = $admin->permissions;

        return view('admin.profile.index', compact('admin', 'permissions'));
    }
}
