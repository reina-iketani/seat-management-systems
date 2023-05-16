<?php

namespace App\Services;

use Carbon\Carbon;

class CalendarService
{
    protected $year;
    protected $month;
    protected $carbon;

    /**
     * コンストラクタ
     *
     * @param int $year
     * @param int $month
     */
    public function __construct($year, $month)
    {
        $this->year = $year;
        $this->month = $month;
        $this->carbon = Carbon::create($year, $month, 1);
         $this->daysInMonth = $this->getDaysInMonth($year, $month);
    }
    
    
    
    public function getDaysInMonth($year, $month)
    {
        return range(1, cal_days_in_month(CAL_GREGORIAN, $month, $year));
    }

    /**
     * カレンダー情報の取得
     *
     * @return array
     */
    public function getCalendar()
    {
        // カレンダー情報を格納するための配列を初期化する
        $calendar = [];
        // カレンダーの1週目の日曜日までの日数を取得する
        $firstDayOfWeek = $this->carbon->dayOfWeek;
        $sub = $firstDayOfWeek - Carbon::SUNDAY;
        if ($sub < 0) {
            $sub += 7;
        }
        $startDate = $this->carbon->copy()->subDays($sub);
        // カレンダーの最終週の土曜日までの日数を取得する
        $lastDayOfWeek = $this->carbon->copy()->endOfMonth()->dayOfWeek;
        $add = Carbon::SATURDAY - $lastDayOfWeek;
        if ($add < 0) {
            $add += 7;
        }
        $endDate = $this->carbon->copy()->endOfMonth()->addDays($add);

        // カレンダー情報を配列に格納する
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $calendar[] = [
                'date' => $date->copy(),
                'day' => $date->day,
                'month' => $date->month,
                'year' => $date->year,
            ];
        }

        return $calendar;
    }

    /**
     * 指定された年月のカレンダー情報を配列に変換する
     *
     * @return array
     */
    public function toArray()
    {
        $calendar = $this->getCalendar();
        $weeksInMonth = $this->getWeeksInMonth($calendar);
        $daysInMonth = $this->getDaysInMonth($calendar);
        $calendarArray = [
            'year' => $this->year,
            'month' => $this->month,
            'weeksInMonth' => $weeksInMonth,
            'daysInMonth' => $daysInMonth,
        ];

        return $calendarArray;
    }

}