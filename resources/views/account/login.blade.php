@extends('layouts.app')

@section('content')
<div class="container">
    <div class="auth-form auth-form--login">
        <h2 class="auth-form__title">ログイン</h2>
        <form method="POST" action="{{ route('login') }}" class="auth-form__form">
            @csrf
            <div class="auth-form__field">
                <label for="email" class="auth-form__label">メールアドレス</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="auth-form__input">
            </div>
            <div class="auth-form__field">
                <label for="password" class="auth-form__label">パスワード</label>
                <input type="password" id="password" name="password" required class="auth-form__input">
            </div>
            <button type="submit" class="auth-form__submit">ログイン</button>
        </form>
    </div>
</div>
@endsection