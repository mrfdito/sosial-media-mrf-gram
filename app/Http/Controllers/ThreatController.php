<?php

namespace App\Http\Controllers;

use App\Models\Threat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreatController extends Controller
{
    // Menampilkan dashboard dengan threat + likes + comments
    public function index()
    {
        $threats = Threat::with(['user', 'likes', 'comments.user'])->latest()->get();
        return view('dashboard', compact('threats'));
    }

    // Menyimpan postingan baru
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:280',
        ]);

        Threat::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('dashboard');
    }
}
