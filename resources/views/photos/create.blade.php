@extends('layouts.app')

@section('content')
<div class="upload-form">
    <h1 class="upload-form__title">Upload New Photo</h1>
    <form action="{{ route('photos.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="upload-form__field">
            <label for="title" class="upload-form__label">Title</label>
            <input type="text" class="upload-form__input" id="title" name="title" required>
        </div>
        <div class="upload-form__field">
            <label for="category" class="upload-form__label">Category</label>
            <input type="text" class="upload-form__input" id="category" name="category" required>
        </div>
        <div class="upload-form__field">
            <label for="photo" class="upload-form__label">Photo</label>
            <input type="file" class="upload-form__file" id="photo" name="photo" required>
        </div>
        <button type="submit" class="upload-form__submit">Upload</button>
    </form>
</div>
@endsection