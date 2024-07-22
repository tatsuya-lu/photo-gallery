
@extends('layouts.app')

@section('content')
<div class="photo-detail">
    <h1 class="photo-detail__title">{{ $photo->title }}</h1>
    <div class="photo-detail__content">
        <img src="{{ asset($photo->path) }}" alt="{{ $photo->title }}" class="photo-detail__image">
        <div class="photo-detail__info">
            <p class="photo-detail__category">Category: {{ $photo->category }}</p>
            <p class="photo-detail__downloads">Downloads: {{ $photo->downloads_count }}</p>
            <div class="photo-detail__actions">
                <a href="{{ route('photos.download', $photo->id) }}" class="photo-detail__button">Download</a>
                @auth
                    <form action="{{ route('photos.favorite', $photo->id) }}" method="POST" class="photo-detail__favorite-form">
                        @csrf
                        <button type="submit" class="photo-detail__button photo-detail__button--favorite">Favorite</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection