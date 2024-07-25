<?php

namespace App\Services;

use App\Models\Photo;
use App\Models\Account;
use App\Models\Category;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class PhotoService
{
    private $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new GdDriver());
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

    public function getUserPhotos(Account $user)
    {
        return Photo::where('user_id', $user->id)->paginate(12);
    }

    public function downloadPhoto($id)
    {
        $photo = Photo::findOrFail($id);
        $photo->increment('downloads_count');
        return response()->download(public_path($photo->path));
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

    public function deletePhoto(Photo $photo)
    {
        if (file_exists(public_path($photo->path))) {
            unlink(public_path($photo->path));
        }

        $photo->delete();
    }

    public function getPhotoById($id)
    {
        return Photo::findOrFail($id);
    }

    public function toggleFavorite(Photo $photo, Account $user)
    {
        if ($photo->isFavoritedBy($user)) {
            $photo->favorites()->detach($user->id);
        } else {
            $photo->favorites()->attach($user->id);
        }
    }

    public function getFavoritePhotos(Account $user)
    {
        return $user->favorites()->paginate(12);
    }

    private function getCategoryIds($categories)
    {
        return Category::whereIn('name', $categories)->pluck('id')->toArray();
    }

    public function getAllCategories()
    {
        return Category::orderBy('name')->get();
    }

    public function updateCategories($categoryString)
    {
        $categories = explode(',', $categoryString);
        $categories = array_map('trim', $categories);

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }
    }
}
