<?php

namespace App\Services;

use App\Models\Photo;
use App\Models\Account;
use App\Models\Category;
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
                    ->orWhereHas('categories', function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', '%' . $searchTerm . '%');
                    });
            });
        }

        if ($request->has('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('name', $request->category);
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

    public function getUserPhotos(Account $account)
    {
        return Photo::where('user_id', $account->id)->paginate(12);
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
        $categories = explode(',', $request->category);
        $categories = array_map('trim', $categories);

        $photo = Photo::create([
            'title' => $request->title,
            'category' => implode(',', $categories),
            'path' => $path,
            'user_id' => auth()->id(),
            'favorites_count' => 0,
        ]);

        $photo->categories()->sync($this->getCategoryIds($categories));
    }

    public function updateCategories($categoryString)
    {
        $categories = explode(',', $categoryString);
        $categories = array_map('trim', $categories);

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }
    }

    private function getCategoryIds($categories)
    {
        return Category::whereIn('name', $categories)->pluck('id')->toArray();
    }

    public function getAllCategories()
    {
        return Category::orderBy('name')->get();
    }

    public function addFavorite($id)
    {
        $photo = Photo::findOrFail($id);
        $photo->favorites()->attach(auth()->id());
    }

    public function deletePhoto(Photo $photo)
    {
        if (file_exists(public_path($photo->path))) {
            unlink(public_path($photo->path));
        }

        $photo->delete();
    }
}
