<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Menampilkan daftar pengguna lain untuk diajak chat
     */
    public function users()
    {
        $authUser = auth()->user();

        // Ambil ID semua user yang pernah chat dengan user ini
        $userIds = Message::where('sender_id', $authUser->id)
            ->orWhere('receiver_id', $authUser->id)
            ->selectRaw('IF(sender_id = ?, receiver_id, sender_id) as user_id', [$authUser->id])
            ->distinct()
            ->pluck('user_id');

        // Ambil user-nya
        $users = User::whereIn('id', $userIds)->get();

        // Tambahkan pesan terakhir ke setiap user
        foreach ($users as $user) {
            $user->last_message = $user->lastMessageWith($authUser->id);
        }

        return view('chat.users', compact('users'));
    }

    /**
     * Menampilkan halaman percakapan dengan user tertentu.
     */
    public function show(User $user)
    {
        $authUserId = Auth::id();

        $messages = Message::where(function ($query) use ($authUserId, $user) {
                $query->where('sender_id', $authUserId)
                      ->where('receiver_id', $user->id);
            })
            ->orWhere(function ($query) use ($authUserId, $user) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', $authUserId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('chat.conversation', compact('user', 'messages'));
    }

    /**
     * Mengirim pesan ke pengguna tertentu (versi non-AJAX).
     */
    public function send(Request $request, User $user)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Message::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $user->id,
            'message'     => $request->message,
        ]);

        return redirect()->route('chat.show', $user->id)->with('success', 'Pesan berhasil dikirim.');
    }
}
