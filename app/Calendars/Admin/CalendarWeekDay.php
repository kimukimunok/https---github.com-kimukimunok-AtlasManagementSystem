<?php

namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;

// スクール予約確認、ここの部数の部分に予約されている数を表示させるようにする。
class CalendarWeekDay
{
    protected $carbon;

    function __construct($date)
    {
        $this->carbon = new Carbon($date);
    }

    function getClassName()
    {
        return "day-" . strtolower($this->carbon->format("D"));
    }

    function render()
    {
        return '<p class="day">' . $this->carbon->format("j") . '日</p>';
    }

    function everyDay()
    {
        return $this->carbon->format("Y-m-d");
    }
    // 予約詳細ページの部数確認箇所
    function dayPartCounts($ymd)
    {
        $html = [];
        $one_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();
        $two_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
        $three_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();

        // $htmlここで表示の部分を操作できる。
        // 部数の詳細へ飛ぶようにするためにはhrefで部数のリンクを作る
        // ルーティングリンクの記述とcalendar.admin.detail
        // 各部に予約された数の表示を取得して表示する。(下の$one_partに予約した数がわかる変数$usersの情報を取得する。)
        // 1部2部3部とそれぞれに$htmlが存在するため、それぞれに変数を当て、予約されている部数を表示させる記述をおこなう。ちなみに、上の方で変数にどの部が対応しているかの記述が存在するため、（1部ならその日の部のID１のような。）下でcount(～)で記述した際に何部から取得するかわかる。
        // この際"とか'とか.の必要な位置に注意したい。
        // count($one_part->users) で、予約された部数の表示を行っている。
        $html[] = '<div class="text-left">';
        if ($one_part) {
            $html[] = '<p class="day_part m-0 pt-1 ">
        <a href="' . route(
                'calendar.admin.detail',
                ['date' => $ymd, 'part' => '1']
            ) . '">1部</a>
         <span>' . count($one_part->users) . '</span>
      </p>';
        }
        if ($two_part) {
            $html[] = '<p class="day_part m-0 pt-1">
            <a href="' . route(
                'calendar.admin.detail',
                ['date' => $ymd, 'part' => '2']
            ) . '">2部</a>
            <span>' . count($two_part->users) . '</span>
            </p>';
        }
        if ($three_part) {
            $html[] = '<p class="day_part m-0 pt-1"><a href="' . route('calendar.admin.detail', ['date' => $ymd, 'part' => '3']) . '">3部</a>
      <span>' . count($three_part->users) . '</span>
      </p>';
        }
        $html[] = '</div>';
        // implodeメソッド→データを結合した文字列を取得する
        // $htmlで指定した文字列、「各部の表示」を表示している。
        return implode("", $html);
    }


    function onePartFrame($day)
    {
        $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first();
        if ($one_part_frame) {
            $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first()->limit_users;
        } else {
            $one_part_frame = "20";
        }
        return $one_part_frame;
    }
    function twoPartFrame($day)
    {
        $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
        if ($two_part_frame) {
            $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first()->limit_users;
        } else {
            $two_part_frame = "20";
        }
        return $two_part_frame;
    }
    function threePartFrame($day)
    {
        $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
        if ($three_part_frame) {
            $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first()->limit_users;
        } else {
            $three_part_frame = "20";
        }
        return $three_part_frame;
    }

    //
    function dayNumberAdjustment()
    {
        $html = [];
        $html[] = '<div class="adjust-area">';
        $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>';
        $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>';
        $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>';
        $html[] = '</div>';
        return implode('', $html);
    }
}
