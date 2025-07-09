<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle($id)
{
    $threat = \App\Models\Threat::findOrFail($id);
    $user = auth()->user();

    if ($threat->isLikedBy($user)) {
        $threat->likes()->where('user_id', $user->id)->delete();
    } else {
        $threat->likes()->create(['user_id' => $user->id]);
    }

    return back();
}

}
