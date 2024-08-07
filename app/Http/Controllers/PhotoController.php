<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PhotoService;
use App\Http\Requests\PhotoRequest;

class PhotoController extends Controller
{
    protected $photoService;

    public function __construct(PhotoService $photoService)
    {
        $this->photoService = $photoService;
    }

    public function index(Request $request)
    {
        $photos = $this->photoService->getPhotos($request);
        $categories = $this->photoService->getAllCategories();
        return view('photos.index', compact('photos', 'categories'));
    }

    public function create()
    {
        return view('photos.create');
    }

    public function upload(PhotoRequest $request)
    {
        $this->photoService->uploadPhoto($request);
        $this->photoService->updateCategories($request->category);
        return redirect()->route('photos.index')->with('success', '写真が正常に投稿されました。');
    }

    public function destroy($id)
    {
        $photo = $this->photoService->getPhotoById($id);

        if ($photo->user_id !== auth()->id()) {
            return redirect()->back()->with('error', '削除する権限がありません。');
        }

        $this->photoService->deletePhoto($photo);
        return redirect()->route('account.photos')->with('success', '写真が削除されました。');
    }

    public function show($id)
    {
        $photo = $this->photoService->getPhotoById($id);
        return view('photos.show', compact('photo'));
    }

    public function toggleFavorite($id)
    {
        $photo = $this->photoService->getPhotoById($id);
        $this->photoService->toggleFavorite($photo, auth()->user());
        return response()->json(['isFavorited' => $photo->isFavoritedBy(auth()->user()), 'favoritesCount' => $photo->favorites_count]);
    }

    public function favoritesList()
    {
        $favorites = $this->photoService->getFavoritePhotos(auth()->user());
        return view('photos.favorites', compact('favorites'));
    }

    public function userPhotos()
    {
        $photos = $this->photoService->getUserPhotos(auth()->user());
        return view('photos.user_photos', compact('photos'));
    }

    public function download($id)
    {
        return $this->photoService->downloadPhoto($id);
    }
}
