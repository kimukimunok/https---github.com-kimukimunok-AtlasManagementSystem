@extends('layouts.sidebar')
<!-- 予約詳細画面ここ -->
@section('content')
<!-- 予約確認画面の日毎のリンク先はここ、ここを編集して日や部やユーザーの表示を行う。 -->
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
    <div class="reserve-detail-width m-auto h-75">
        <!-- 日の取得は$dateで取得できる。 -->
        <p style="font-size: 20px;"><span>{{$date}}日</span>
            <!-- 部の取得は$partで取得できる。 -->
            <span class="ml-3">{{$part}}部</span>
        </p>
        <!-- ID,名前,場所 -->
        <div class="reserve-detail">
            <table class="reserve-detail-in">
                <tr class=" text-center">
                    <th class="reserve-detail-th">ID</th>
                    <th class="reserve-detail-th">名前</th>
                    <!-- 場所の追加 -->
                    <th class="reserve-detail-th">場所</th>
                </tr>
                @foreach($reservePersons as $reservePerson)
                @foreach($reservePerson->users as $user)
                <!-- 下の記載で色をユーザー毎に交互に炉を変える記述をする。 -->
                <tr class="reserve-detail-user text-center">
                    <!-- ユーザーIDと苗字名前を取得している。 -->
                    <th>{{$user->id}}</th>
                    <th>{{$user->over_name}}{{$user->under_name}}</th>
                    <!-- 場所を表示する。現状リモートしか存在しないためリモートと記述 -->
                    <th>リモート</th>
                </tr>
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
