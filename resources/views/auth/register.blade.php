@extends('layouts.app')

@section('content')
<div class="container">
    <h2>アカウント登録</h2>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="name">名前</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
        </div>
        <div>
            <label for="nickname">ニックネーム</label>
            <input id="nickname" type="text" name="nickname" value="{{ old('nickname') }}">
        </div>
        <div>
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password" required>
        </div>
        <div>
            <label for="password_confirmation">パスワード (確認)</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>
        <div>
            <label for="profile_image">プロフィール画像</label>
            <input id="profile_image" type="file" name="profile_image">
        </div>
        <div>
            <label for="bio">自己紹介</label>
            <textarea id="bio" name="bio">{{ old('bio') }}</textarea>
        </div>
        <div>
            <button type="submit">登録</button>
        </div>
    </form>
</div>
@endsection