@extends('layouts.app')

@section('content')
<div class="gallery">
    <h1 class="gallery__title">Photo Gallery</h1>
    <div class="gallery__grid">
        @foreach($photos as $photo)
            <div class="photo-card">
                <img src="{{ asset('storage/' . $photo->path) }}" class="photo-card__image" alt="{{ $photo->title }}">
                <div class="photo-card__body">
                    <h5 class="photo-card__title">{{ $photo->title }}</h5>
                    <p class="photo-card__text">Category: {{ $photo->category }}</p>
                    <p class="photo-card__text">Downloads: {{ $photo->downloads_count }}</p>
                    <div class="photo-card__actions">
                        <a href="{{ route('photos.download', $photo->id) }}" class="photo-card__button">Download</a>
                        @auth
                            <form action="{{ route('photos.favorite', $photo->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="photo-card__button photo-card__button--favorite">Favorite</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection