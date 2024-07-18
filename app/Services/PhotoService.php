<?php

namespace App\Services;

use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class PhotoService
{
    private $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new GdDriver());
    }

    private function savePhoto($image)
    {
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $path = public_path('img/photos');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $fullPath = $path . '/' . $filename;

        $img = $this->imageManager->read($image->getRealPath());
        $img->save($fullPath);

        return 'img/photos/' . $filename;
    }

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
        return response()->download(public_path($photo->path));
    }

    public function uploadPhoto($request)
    {
        $path = $this->savePhoto($request->file('photo'));
        Photo::create([
            'title' => $request->title,
            'category' => $request->category,
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