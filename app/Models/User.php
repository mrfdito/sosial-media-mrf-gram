<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
protected $fillable = [
    'name',
    'email',
    'password',
    'bio', // jika kamu masih pakai bio
];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke threats
     */
    public function threats()
    {
        return $this->hasMany(Threat::class);
    }

    /**
     * Relasi ke pesan yang dikirim
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Relasi ke pesan yang diterima
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    

    public function lastMessageWith($otherUserId)
{
    return \App\Models\Message::where(function ($q) use ($otherUserId) {
            $q->where('sender_id', $this->id)
              ->where('receiver_id', $otherUserId);
        })
        ->orWhere(function ($q) use ($otherUserId) {
            $q->where('sender_id', $otherUserId)
              ->where('receiver_id', $this->id);
        })
        ->latest()
        ->first();
}

public function likes()
{
    return $this->hasMany(Like::class);
}

public function comments()
{
    return $this->hasMany(Comment::class);
}


}
