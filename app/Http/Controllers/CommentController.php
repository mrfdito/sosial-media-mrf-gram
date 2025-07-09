<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $threatId)
{
    $request->validate([
        'comment' => 'required|string|max:1000',
    ]);

    \App\Models\Comment::create([
        'user_id' => auth()->id(),
        'threat_id' => $threatId,
        'comment' => $request->comment,
    ]);

    return back();
}

}
