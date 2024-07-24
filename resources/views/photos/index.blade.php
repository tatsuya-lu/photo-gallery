@extends('layouts.app')

@section('content')
    <div class="gallery">
        <h1 class="gallery__title">Photo Gallery</h1>

        <form action="{{ route('photos.index') }}" method="GET" class="search-form">
            <input type="text" name="search" placeholder="タイトルかカテゴリーを入力してください。" value="{{ request('search') }}" class="search-form__input">
            <div class="search-form__select-wrapper">
                <select name="sort_order" class="search-form__select">
                    <option value="desc" {{ request('sort_order', 'desc') == 'desc' ? 'selected' : '' }}>新着順</option>
                    <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>古い順</option>
                </select>
                <span class="search-form__select-icon">
                    <i class="fas fa-chevron-down"></i>
                </span>
            </div>
            <button type="submit" class="search-form__button">検索</button>
        </form>        
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
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $photos->appends(request()->query())->links() }}
        <div class="categories">
            <h2 class="categories__title">カテゴリー</h2>
            <div class="categories__list">
                @foreach($categories as $category)
                    <a href="{{ route('photos.index', ['category' => $category->name]) }}" class="categories__item">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
