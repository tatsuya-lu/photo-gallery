<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'path',
        'user_id',
        'downloads_count',
        'favorites_count',
    ];

    public function favorites()
    {
        return $this->belongsToMany(Account::class, 'favorites')->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function isFavoritedBy(Account $user)
    {
        return $this->favorites->contains($user);
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites()->count();
    }
}
