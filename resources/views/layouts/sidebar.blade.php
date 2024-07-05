<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AtlasBulletinBoard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&family=Oswald:wght@200&display=swap" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<!-- C:\Users\goof-\AtlasManagementSystem\public\image
↑にアイコン画像入れました。 -->

<body class="all_content">
    <div class="d-flex">
        <div class="sidebar">
            @section('sidebar')
            <p class="sidebarp1"><a href="{{ route('top.show') }}">マイページ</a></p>
            <p><a href="/logout">ログアウト</a></p>
            <p><a href="{{ route('calendar.general.show',['user_id' => Auth::id()]) }}">スクール予約</a></p>
            <!-- ・スクール予約確認と・スクール枠登録を講師のみに表示させるようにしたい→講師のみがみられるようにauth設定をする。 -->
            <!-- 講師とそれ以外の違いは何か？＝役職が講師か生徒か→DBだと権限ナンバー？、生徒が”4”で講師が”1” -->
            @auth
            <!-- 講師(権限が1,2,3)つまり生徒:4以外の時authの範囲内を表示する。 -->
            <!-- !()で囲むと指定した以外を選択するとなる -->
            @if(!(Auth::user()->role == 4))
            <p><a href="{{ route('calendar.admin.show',['user_id' => Auth::id()]) }}">スクール予約確認</a></p>
            <p><a href="{{ route('calendar.admin.setting',['user_id' => Auth::id()]) }}">スクール枠登録</a></p>
            @endif
            @endAuth
            <p><a href="{{ route('post.show') }}">掲示板</a></p>
            <p><a href="{{ route('user.show') }}">ユーザー検索</a></p>
            @show
        </div>
        <div class="main-container">
            @yield('content')
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/register.js') }}" rel="stylesheet"></script>
    <script src="{{ asset('js/bulletin.js') }}" rel="stylesheet"></script>
    <script src="{{ asset('js/user_search.js') }}" rel="stylesheet"></script>
    <script src="{{ asset('js/calendar.js') }}" rel="stylesheet"></script>
</body>

</html>
