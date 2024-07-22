<?php

namespace App\Services;

use App\Models\Photo;
use App\Models\Account;
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

    public function getPhotos($request)
    {
        $query = Photo::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('category', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy('created_at', $sortOrder);

        return $query->paginate(12);
    }

    public function getPhotoById($id)
    {
        return Photo::findOrFail($id);
    }

    public function toggleFavorite(Photo $photo, Account $account)
    {
        if ($photo->isFavoritedBy($account)) {
            $photo->favorites()->detach($account->id);
        } else {
            $photo->favorites()->attach($account->id);
        }
    }

    public function getFavoritePhotos(Account $account)
    {
        return $account->favorites()->paginate(12);
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
            'favorites_count' => 0,
        ]);
    }

    public function addFavorite($id)
    {
        $photo = Photo::findOrFail($id);
        $photo->favorites()->attach(auth()->id());
    }
}
