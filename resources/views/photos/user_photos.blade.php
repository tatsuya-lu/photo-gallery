@extends('layouts.app')

@section('content')
    <div class="gallery">
        <h1 class="gallery__title">マイフォト</h1>
        <div class="gallery__grid">
            @foreach ($photos as $photo)
                <div class="photo-card">
                    <a href="{{ route('photos.show', $photo->id) }}" class="photo-card__link">
                        <img src="{{ asset($photo->path) }}" class="photo-card__image" alt="{{ $photo->title }}">
                    </a>
                    <div class="photo-card__body">
                        <h5 class="photo-card__title">{{ $photo->title }}</h5>
                        <p class="photo-card__text">カテゴリー: {{ $photo->category }}</p>
                        <p class="photo-card__text">ダウンロード数: {{ $photo->downloads_count }}</p>
                        <div class="photo-card__actions">
                            <a href="{{ route('photos.download', $photo->id) }}" class="photo-card__button">ダウンロード</a>
                            @auth
                                <button type="button" class="photo-card__button photo-card__button--favorite"
                                    data-photo-id="{{ $photo->id }}"
                                    data-is-favorited="{{ $photo->isFavoritedBy(auth()->user()) ? 'true' : 'false' }}">
                                    <i class="fas fa-heart"></i>
                                    <span class="favorites-count">{{ $photo->favorites_count }}</span>
                                </button>
                                <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('本当にこの写真を削除しますか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">削除</button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $photos->links() }}
    </div>
@endsection
