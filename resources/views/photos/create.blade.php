@extends('layouts.app')

@section('content')
<div class="upload-form">
    <h1 class="upload-form__title">写真を投稿する</h1>
    <form action="{{ route('photos.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="upload-form__field">
            <label for="title" class="upload-form__label">タイトル</label>
            <input type="text" class="upload-form__input" id="title" name="title" required>
        </div>
        <div class="upload-form__field">
            <label for="category" class="upload-form__label">カテゴリー</label>
            <input type="text" class="upload-form__input" id="category" name="category" required>
        </div>
        <div class="upload-form__field">
            <label for="photo" class="upload-form__label">写真</label>
            <input type="file" class="upload-form__file" id="photo" name="photo" required>
        </div>
        <button type="submit" class="upload-form__submit">投稿</button>
    </form>
</div>
@endsection