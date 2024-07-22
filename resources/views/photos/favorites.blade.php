@extends('layouts.app')

@section('content')
<div class="gallery">
    <h1 class="gallery__title">お気に入り写真</h1>
    <div class="gallery__grid">
        @foreach($favorites as $photo)
        <div class="photo-card">
            <a href="{{ route('photos.show', $photo->id) }}" class="photo-card__link">
                <img src="{{ asset($photo->path) }}" class="photo-card__image" alt="{{ $photo->title }}">
            </a>
            <div class="photo-card__body">
                <h5 class="photo-card__title">{{ $photo->title }}</h5>
                <p class="photo-card__text">Category: {{ $photo->category }}</p>
                <p class="photo-card__text">Downloads: {{ $photo->downloads_count }}</p>
                <div class="photo-card__actions">
                    <a href="{{ route('photos.download', $photo->id) }}" class="photo-card__button">Download</a>
                    @auth
                        <button type="button" class="photo-card__button photo-card__button--favorite"
                            data-photo-id="{{ $photo->id }}"
                            data-is-favorited="{{ $photo->isFavoritedBy(auth()->user()) ? 'true' : 'false' }}">
                            <i class="fas fa-heart"></i>
                            <span class="favorites-count">{{ $photo->favorites_count }}</span>
                        </button>
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $favorites->links() }}
</div>
@endsection