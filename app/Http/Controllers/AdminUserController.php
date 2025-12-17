<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('is_approved', 0)->get();
        return view('admin.dashboard', compact('pendingUsers'));
    }

    public function approve($id)
    {
        $user = User::find($id);
        $user->is_approved = 1;
        $user->save();

        return back()->with('message', '承認しました！');
    }
}
