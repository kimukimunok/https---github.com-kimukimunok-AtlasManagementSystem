@extends('layouts.sidebar')

@section('content')
<!-- 予約確認画面の日毎のリンク先はここ、ここを編集して日や部やユーザーの表示を行う。 -->
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
    <div class="w-50 m-auto h-75">
        <!-- 日の取得は$dateで取得できる。 -->
        <p><span>{{$date}}日</span>
            <!-- 部の取得は$partで取得できる。 -->
            <span class="ml-3">{{$part}}部</span>
        </p>
        <!-- ID,名前,場所 -->
        <div class="h-75 border">
            <table class="">
                <tr class="text-center">
                    <th class="w-25">ID</th>
                    <th class="w-25">名前</th>
                    <!-- 場所の追加 -->
                    <th class="w-25">場所</th>
                </tr>
                <!-- 変数がおかしくてエラー出ていたが、予約詳細(ユーザーIDと予約日と予約部)は変数reserveParsonに入っているからそれを入力 -->
                @foreach($reservePersons as $reservePerson)
                @foreach($reservePerson->users as $user)
                <tr class="text-center">
                    <!-- ここから記述 -->
                    <!-- ユーザーIDと苗字名前を取得している。 -->
                    <th>{{$user->id}}</th>
                    <th>{{$user->over_name}}{{$user->under_name}}</th>
                    <!-- 場所を表示する。現状リモートしか存在しないためリモートと記述 -->
                    <th>リモート</th>
                </tr>
                <!-- 予約が複数人いる場合の色合いの変更はまだ -->
                @endforeach
                @endforeach
                <tr class="text-center">
                    <td class="w-25"></td>
                    <td class="w-25"></td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
