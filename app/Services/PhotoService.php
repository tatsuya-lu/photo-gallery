<?php

namespace App\Services;

use App\Models\Photo;
use Illuminate\Support\Facades\Storage;

class PhotoService
{
    public function getAllPhotos()
    {
        return Photo::all();
    }

    public function searchPhotos($keyword)
    {
        return Photo::where('title', 'LIKE', '%' . $keyword . '%')->get();
    }

    public function downloadPhoto($id)
    {
        $photo = Photo::findOrFail($id);
        $photo->increment('downloads_count');
        return Storage::download($photo->path);
    }

    public function uploadPhoto($request)
    {
        $path = $request->file('photo')->store('photos');
        Photo::create([
            'title' => $request->title,
            'path' => $path,
            'user_id' => auth()->id(),
        ]);
    }

    public function addFavorite($id)
    {
        $photo = Photo::findOrFail($id);
        $photo->favorites()->attach(auth()->id());
    }
}
