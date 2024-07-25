@extends('layouts.app')

@section('content')
<div class="container">
    <div class="auth-form auth-form--login">
        <h2 class="auth-form__title">ログイン</h2>
        <form method="POST" action="{{ route('login') }}" class="auth-form__form" novalidate>
            @csrf
            <div class="auth-form__field">
                <label for="email" class="auth-form__label">メールアドレス</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="auth-form__input @error('email') auth-form__input--error @enderror">
                @error('email')
                    <span class="auth-form__error">{{ $message }}</span>
                @enderror
            </div>
            <div class="auth-form__field">
                <label for="password" class="auth-form__label">パスワード</label>
                <input type="password" id="password" name="password" required class="auth-form__input @error('password') auth-form__input--error @enderror">
                @error('password')
                    <span class="auth-form__error">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="auth-form__submit">ログイン</button>
        </form>
    </div>
</div>
@endsection