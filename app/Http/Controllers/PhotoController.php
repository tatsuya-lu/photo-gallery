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

    public function index()
    {
        $photos = $this->photoService->getAllPhotos();
        return view('photos.index', compact('photos'));
    }

    public function search(Request $request)
    {
        $photos = $this->photoService->searchPhotos($request->query('keyword'));
        return view('photos.index', compact('photos'));
    }

    public function download($id)
    {
        return $this->photoService->downloadPhoto($id);
    }

    public function create()
    {
        return view('photos.create');
    }

    public function upload(PhotoRequest $request)
    {
        $this->photoService->uploadPhoto($request);
        return redirect()->route('photos.index')->with('success', 'Photo uploaded successfully');
    }

    public function favorite($id)
    {
        $this->photoService->addFavorite($id);
        return redirect()->back()->with('success', 'Photo added to favorites');
    }
}
