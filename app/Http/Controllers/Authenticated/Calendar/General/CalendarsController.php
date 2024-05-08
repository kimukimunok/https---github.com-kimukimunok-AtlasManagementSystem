<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    public function show()
    {
        // CalendarView(time())は現在時刻を取得して、当月のカレンダーを表示させる。
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }
    // 予約機能
    public function reserve(Request $request)
    {
        //トランザクション開始？＝複数の処理を一つにまとめてデータベースに反映させること
        DB::beginTransaction();
        try {
            // getPart=枠getdate=日時を$request変数一つにしている。array_combineで
            $getPart = $request->getPart;
            $getDate = $request->getData;
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            // 予約する(データベースに登録)
            foreach ($reserveDays as $key => $value) {
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                // limit_usersは予約人数のこと（デフォルトで20が選択されている。）decrementで減っている。反対(追加)はincrementとなる
                $reserve_settings->decrement('limit_users');
                // useridをテーブルに追加している。
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }
    // キャンセル処理多分ここに記述。
    public function delete(request $request)
    {

        DB::beginTransaction();
        try {
            $getPart = $request->getPart;
            $getDate = $request->getData;
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            // 予約情報の削除をする
            // ここの記載ってそもそも何やってるの→「https://www.javadrive.jp/php/for/index9.html」
            // foreach　でキーを取り出す構文＝reserveDaysの値を繰り返し処理で表示している。
            // なんで繰り返し処理だったのか、→予約の際はいくつかの日程の予約が可能だったため。反対にキャンセルの場合は繰り返し処理ではなく一度に一回分のキャンセルしかできないため、foreachは使わない。
            // foreach ($reserveDays as $key => $value) {
            // $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
            // reserve_settingsとは、予約した枠
            // 繰り返し処理を消して、取得するものを予約日と予約時間にしたつもり
            // $getPartと$getDate
            // dd($getDate);

            $reserve_settings = ReserveSettings::where('setting_reserve', $getPart)->where('setting_part', $getDate)->first();
            // dd($reserve_settings);

            // 予約を１回分戻す記述(incrementで戻すことが可能)
            $reserve_settings->increment('limit_users');
            // usersテーブルから予約（reserve_settings）を削除している
            $reserve_settings->users()->detach(Auth::id());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }
}
