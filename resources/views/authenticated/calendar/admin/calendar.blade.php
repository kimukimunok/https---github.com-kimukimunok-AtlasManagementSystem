@extends('layouts.sidebar')

@section('content')
<div class="w-75 m-auto">
    <div class="w-100">
        <p>{{ $calendar->getTitle() }}</p>
        <p>{!! $calendar->render() !!}</p>
    </div>
</div>
<!-- キャンセルモーダルを作る。 -->
<div class="modal js-modal-cancel">
    <div class="modal__bg js-modal-close"></div>
    <div class="modal__content">
        <!-- キャンセル用のformタグ -->
        <form action="{{route('deleteParts')}}" method="post">
            <!-- 予約日 -->
            <!-- readonlyでデータを送っている。 -->
            <p>予約日 <input type="text" id="delete_date" name="delete_date" value="" readonly form="deleteParts"></p>
            <!-- 時間・リモ -->
            <p>時間：リモ<input type="text" id="delete_part" name="delete_part" value="" readonly form="deleteParts">部</p>
            <!-- キャンセル確認の文章 -->
            <p>上記の予約をキャンセルしてもよろしいですか？</p>
            <div class="w-50 m-auto edit-modal-btn d-flex">
                <a class="js-modal-close btn btn-danger d-inline-block" href="">閉じる</a>
                <!-- キャンセルボタン　-->
                <input type="submit" class="btn btn-primary d-block" value="キャンセル">
            </div>
            {{ csrf_field() }}
        </form>
    </div>
</div>
@endsection
