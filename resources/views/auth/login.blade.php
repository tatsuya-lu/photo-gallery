@extends('layouts.app')

@section('content')
<div class="container">
    <h2>ログイン</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div>
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password" required>
        </div>
        {{-- <div>
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">ログイン状態を保持する</label>
        </div> --}}
        <div>
            <button type="submit">ログイン</button>
        </div>
    </form>
    {{-- <a href="{{ route('password.request') }}">パスワードをお忘れですか？</a> --}}
</div>
@endsection