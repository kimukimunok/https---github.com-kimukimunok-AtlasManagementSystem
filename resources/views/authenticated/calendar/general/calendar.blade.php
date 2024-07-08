@extends('layouts.sidebar')
<!-- スクール予約画面 -->
@section('content')
<div>
    <div class="border calendar_back1 calendar_width pt-5 pb-5">
        <p class="text-center">{{ $calendar->getTitle() }}</p>
        <div class="w-75 m-auto" style="border-radius:5px;">
            <div class="">
                {!! $calendar->render() !!}
            </div>
        </div>
        <div class="text-right w-75 m-auto">
            <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
        </div>
    </div>
</div>

<!-- キャンセルモーダルの中身 -->
<div class="modal js-modal-cancel">
    <div class="modal__bg js-modal-close"></div>
    <div class="modal__content">
        <!-- web.php記載のルーティング -->
        <form action="{{ route('deleteParts') }}" method="post" id="deleteParts">
            <!-- モーダルの中身ここから -->

            <!-- 日時と予約した部数の表示もここで行う。 -->
            <!-- // 予約日=$reserveDay 予約時間=$reservePart -->
            <!-- 5/8モーダル内に表示する予約日と予約時間を表示したい。→JSで指定したクラスをinput type textでやると思う。 -->
            <!-- reserveDays reserveParts -->
            <!-- 予約日 -->
            <!-- divクラスでJS内で作ったクラスmodal_reserveを指定 -->
            <div class="modal_reserve">
                <p>予約日：<input type="text" style="border:none" id="reserveDays" name="reserveDays" value="" readonly form="deleteParts"></p>
                <!-- 予約時間 -->

                <p>予約：<input type="text" style="border:none" id="reserveParts" name="reserveParts" value="" readonly form="deleteParts"></p>
                <!-- 文章 -->
                <!-- <input type="hidden" value="1" name="test"> -->
                <p>上記の予約をキャンセルしてもよろしいですか？</p>
            </div>
            <!-- 閉じるボタン→ok -->
            <button type="button" class="js-modal-close btn btn-danger">閉じる</button>
            <!-- キャンセルボタンも必要 -->
            <input type="submit" class="btn btn-primary d-block" value="キャンセル" form="deleteParts">
            {{csrf_field()}}
        </form>
    </div>
</div>
@endsection
