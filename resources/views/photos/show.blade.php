@extends('layouts.app')

@section('content')
    <div class="photo-detail">
        <h1 class="photo-detail__title">{{ $photo->title }}</h1>
        <div class="photo-detail__content">
            <img src="{{ asset($photo->path) }}" alt="{{ $photo->title }}" class="photo-detail__image">
            <div class="photo-detail__info">
                <p class="photo-detail__category">カテゴリー: {{ $photo->category }}</p>
                <p class="photo-detail__downloads">ダウンロード数: {{ $photo->downloads_count }}</p>
                <div class="photo-detail__actions">
                    <a href="{{ route('photos.download', $photo->id) }}" class="photo-detail__button">ダウンロード</a>
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
    </div>
@endsection
