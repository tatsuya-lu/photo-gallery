@extends('layouts.app')

@section('content')
<div class="upload-form">
    <h1 class="upload-form__title">写真を投稿する</h1>
    <form action="{{ route('photos.upload') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="upload-form__field">
            <label for="title" class="upload-form__label">タイトル</label>
            <input type="text" class="upload-form__input @error('title') auth-form__input--error @enderror" id="title" name="title" value="{{ old('title') }}" required>
            @error('title')
                <span class="auth-form__error">{{ $message }}</span>
            @enderror
        </div>
        <div class="upload-form__field">
            <label for="category" class="upload-form__label">カテゴリー（カンマ区切りで複数入力可能）</label>
            <input type="text" class="upload-form__input @error('category') auth-form__input--error @enderror" id="category" name="category" value="{{ old('category') }}" required>
            @error('category')
                <span class="auth-form__error">{{ $message }}</span>
            @enderror
        </div>
        <div class="upload-form__field">
            <label for="photo" class="upload-form__label">写真</label>
            <input type="file" class="upload-form__file @error('photo') auth-form__file--error @enderror" id="photo" name="photo" required>
            @error('photo')
                <span class="auth-form__error">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="upload-form__submit">投稿</button>
    </form>
</div>
@endsection