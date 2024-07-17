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
    ];

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}