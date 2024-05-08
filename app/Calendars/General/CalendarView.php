<?php

namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

class CalendarView
{

    private $carbon;
    function __construct($date)
    {
        $this->carbon = new Carbon($date);
    }

    public function getTitle()
    {
        return $this->carbon->format('Y年n月');
    }

    function render()
    {
        $html = [];
        $html[] = '<div class="calendar text-center">';
        $html[] = '<table class="table">';
        $html[] = '<thead>';
        $html[] = '<tr>';
        $html[] = '<th>月</th>';
        $html[] = '<th>火</th>';
        $html[] = '<th>水</th>';
        $html[] = '<th>木</th>';
        $html[] = '<th>金</th>';
        $html[] = '<th>土</th>';
        $html[] = '<th>日</th>';
        $html[] = '</tr>';
        $html[] = '</thead>';
        $html[] = '<tbody>';
        $weeks = $this->getWeeks();
        foreach ($weeks as $week) {
            $html[] = '<tr class="' . $week->getClassName() . '">';

            $days = $week->getDays();
            foreach ($days as $day) {
                $startDay = $this->carbon->copy()->format("Y-m-01");
                $toDay = $this->carbon->copy()->format("Y-m-d");
                // もし過去日なら～
                if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
                    // CSS記述にクラスのpast-dayがありそれを指定して、過去日の背景色をグレーに
                    $html[] = '<td class="calendar-td past-day">';
                } else {
                    $html[] = '<td class="calendar-td ' . $day->getClassName() . '">';
                }
                $html[] = $day->render();
                // 予約機能（選択されたものをコントローラー側に送る。）
                // 予約された日の部数を取得している。
                if (in_array($day->everyDay(), $day->authReserveDay())) {
                    $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;


                    if ($reservePart == 1) {
                        $reservePart = "リモ1部";
                    } else if ($reservePart == 2) {
                        $reservePart = "リモ2部";
                    } else if ($reservePart == 3) {
                        $reservePart = "リモ3部";
                    }
                    // 今日より前の日程
                    // 5/8ここの記述で過去予約していた日に予約部を表示させる記述が必要となる。変数→$reservePartかと→できた。
                    if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
                        $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">' . $reservePart . '</p>';
                        $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
                        // 今日より後の日程
                        // ここでキャンセルボタンを表示する記述を書き、(予約されていればキャンセルボタンを表示させるようにして押したらキャンセル時のモーダル'(java)が出るようにする。)
                    } else {
                        // クラスにキャンセルモーダル(modal-cancel)を追加→javaで
                        // モーダル内にも予約日と予約時間を表示させるため、予約日と予約時間の情報をモーダルに送るようにする。
                        // 上の送るようにする。というのは、改修課題遷移図を見ると、予約日と予約された部数が表示されているため、やることとすれば、予約した日と部数が取得して、それを表示できればいいということになる。
                        // てことは、モーダル上での表示になるからこっちは記述いらないはず。→まずは予約日のボタンを押したら、キャンセルモーダルを開くところを目指す。

                        // 予約日=$reserveDay 予約時間=$reservePart
                        $html[] = '<button type="submit" class=" modal-cancel btn btn-danger p-0 w-75" name="delete_date" style="font-size:12px"
                        value="' .

                            // $days = $week->getDays→$dayは日一つ一つを表す。予約された部を取得している？
                            $day->authReserveDate($day->everyDay())->first()->setting_reserve . '">' . $reservePart . '</button>';

                        // 表示に関しては以下
                        $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
                    }
                    // 予約をしていない日の表示↓
                } else {
                    //今より前の日を指定する記述
                    if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
                        //今より前の日付に受付終了を表示させる。
                        $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">受付終了</p>';
                        $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
                        // 先の予定の記述
                    } else {
                        $html[] = $day->selectPart($day->everyDay());
                    }
                }
                $html[] = $day->getDate();
                $html[] = '</td>';
            }
            $html[] = '</tr>';
        }
        $html[] = '</tbody>';
        $html[] = '</table>';
        $html[] = '</div>';
        $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">' . csrf_field() . '</form>';
        $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">' . csrf_field() . '</form>';

        return implode('', $html);
    }

    protected function getWeeks()
    {
        $weeks = [];
        $firstDay = $this->carbon->copy()->firstOfMonth();
        $lastDay = $this->carbon->copy()->lastOfMonth();
        $week = new CalendarWeek($firstDay->copy());
        $weeks[] = $week;
        $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
        while ($tmpDay->lte($lastDay)) {
            $week = new CalendarWeek($tmpDay, count($weeks));
            $weeks[] = $week;
            $tmpDay->addDay(7);
        }
        return $weeks;
    }
}
