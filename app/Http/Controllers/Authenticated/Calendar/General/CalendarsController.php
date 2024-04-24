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
}
