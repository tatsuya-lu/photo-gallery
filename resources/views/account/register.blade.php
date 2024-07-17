@extends('layouts.app')

@section('content')
<div class="container">
    <div class="auth-form auth-form--register">
        <h2 class="auth-form__title">アカウント登録</h2>
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="auth-form__form">
            @csrf
            <div class="auth-form__field">
                <label for="name" class="auth-form__label">名前</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="auth-form__input">
            </div>
            <div class="auth-form__field">
                <label for="nickname" class="auth-form__label">ニックネーム</label>
                <input type="text" id="nickname" name="nickname" value="{{ old('nickname') }}" class="auth-form__input">
            </div>
            <div class="auth-form__field">
                <label for="email" class="auth-form__label">メールアドレス</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="auth-form__input">
            </div>
            <div class="auth-form__field">
                <label for="password" class="auth-form__label">パスワード</label>
                <input type="password" id="password" name="password" required class="auth-form__input">
            </div>
            <div class="auth-form__field">
                <label for="password_confirmation" class="auth-form__label">パスワード（確認）</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required class="auth-form__input">
            </div>
            <div class="auth-form__field">
                <label for="profile_image" class="auth-form__label">プロフィール画像</label>
                <input type="file" id="profile_image" name="profile_image" class="auth-form__file">
            </div>
            <div class="auth-form__field">
                <label for="bio" class="auth-form__label">自己紹介</label>
                <textarea id="bio" name="bio" class="auth-form__textarea">{{ old('bio') }}</textarea>
            </div>
            <button type="submit" class="auth-form__submit">登録</button>
        </form>
    </div>
</div>
@endsection