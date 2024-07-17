<!-- 予約枠登録画面 -->
@extends('layouts.sidebar')
@section('content')
<div>
        <div class="calendar_back1 calendar_back2 vh-100 d-flex">
        <div class="reserve_setting_inner w-100 vh-100 border p-5">
            <!-- 月のデータを取得する。 -->
            <p class="reserve_setting_month text-center">{{ $calendar->getTitle() }}</p>
            {!! $calendar->render() !!}
            <div class="adjust-table-btn m-auto text-right">
                <input type="submit" class="btn btn-primary" value="登録" form="reserveSetting" onclick="return confirm('登録してよろしいですか？')">
            </div>
        </div>
    </div>
</div>

<!-- memo
表示をどうするか、まずバックは白に月頭の曜日は濃いグレーに、 過去日は薄灰色、今日以降から月末までは白とする。-->
@endsection
