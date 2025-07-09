<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Threat extends Model
{
    protected $fillable = ['user_id', 'content'];

    // Relasi ke user pembuat postingan
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke like
    public function likes()
    {
        return $this->hasMany(\App\Models\Like::class);
    }

    // Relasi ke komentar
    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class)->latest();
    }

    // Cek apakah user sudah like
    public function isLikedBy($user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
