@extends('layouts.app')

@section('content')
<div class="container">
    <h2>アカウント情報編集</h2>
    <form method="POST" action="{{ route('account.edit') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="name">名前</label>
            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>
        </div>
        <div>
            <label for="nickname">ニックネーム</label>
            <input id="nickname" type="text" name="nickname" value="{{ old('nickname', $user->nickname) }}">
        </div>
        <div>
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>
        <div>
            <label for="profile_image">プロフィール画像</label>
            <input id="profile_image" type="file" name="profile_image">
        </div>
        <div>
            <label for="bio">自己紹介</label>
            <textarea id="bio" name="bio">{{ old('bio', $user->bio) }}</textarea>
        </div>
        <div>
            <button type="submit">更新</button>
        </div>
    </form>
</div>
@endsection