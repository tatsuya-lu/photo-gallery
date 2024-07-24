<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/d8cd936af6.js" crossorigin="anonymous"></script>

    <!-- reset.css ress -->
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="page">
    <header class="header">
        <div class="header__container">
            <a href="{{ route('photos.index') }}" class="header__logo">Photo Gallery</a>
            <nav class="header__nav">
                @guest
                    <a href="{{ route('login') }}" class="header__link">ログイン</a>
                    <a href="{{ route('register') }}" class="header__link">アカウント登録</a>
                @else
                    <a href="{{ route('photos.create') }}" class="header__link">写真を投稿する</a>
                    <a href="{{ route('photos.favorites')}}" class="header__link">お気に入り一覧</a>
                    <a href="{{ route('account.photos') }}" class="header__link">投稿した写真一覧</a>
                    <div class="header__user">
                        <a href="#" class="header__user-link header__link" id="userDropdown" role="button" aria-expanded="false">
                            <span class="header__user-name">{{ Auth::user()->nickname ?? Auth::user()->name }}</span>
                            <img src="{{ Auth::user()->profile_image ? asset('img/profile/' . Auth::user()->profile_image) : asset('img/noimage.png') }}" alt="プロフィール画像" class="header__user-image">
                        </a>
                        <ul class="header__dropdown" aria-labelledby="userDropdown">
                            <li><a class="header__dropdown-item" href="{{ route('account.edit') }}">アカウント情報の編集</a></li>
                            <li><hr class="header__dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="header__logout-form">
                                    @csrf
                                    <button type="submit" class="header__dropdown-item">ログアウト</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </nav>
        </div>
    </header>
    <main class="main">
        @yield('content')
    </main>
    <footer class="footer">
        <div class="footer__container">
            <p class="footer__copyright">&copy; {{ date('Y') }} Photo Gallery. All rights reserved.</p>
        </div>
    </footer>
    <script src="{{ asset('js/favorite.js') }}"></script>
    <script src="{{ asset('js/delete_photo.js') }}"></script>
</body>

</html>
