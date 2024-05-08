@extends('layouts.sidebar')

@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
    <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
        <div class="w-75 m-auto border" style="border-radius:5px;">

            <p class="text-center">{{ $calendar->getTitle() }}</p>
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
        <form action="{{ route('deleteParts') }}" method="post">
            <!-- モーダルの中身ここから -->

            <!-- 日時と予約した部数の表示もここで行う。 -->
            <!-- // 予約日=$reserveDay 予約時間=$reservePart -->
            <p>$reservePart->reservePart</p>
            <p>モーダルテスト！成功！</p>
            <!-- 閉じるボタン -->
            <!-- キャンセルボタンも必要 -->
            <input type="submit" class="btn btn-primary d-block" value="キャンセル">
            {{csrf_field()}}
        </form>
    </div>
</div>
@endsection
