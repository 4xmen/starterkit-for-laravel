<?php

namespace Xmen\StarterKit\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Xmen\StarterKit\Models\AdminLog;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = AdminLog::latest()->paginate(30);

        return view('starter-kit::admin.LogIndex', compact('logs'));
    }
    public function user(User $user)
    {
        $logs = $user->logs()->latest()->paginate(30);

        return view('starter-kit::admin.LogIndex', compact('logs'));
    }
}
