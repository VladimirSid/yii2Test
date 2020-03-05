<?php


namespace common\classes;


class UsefullFunctions
{
    //
    // генератор случайного цвета в HEX формате без #
    //
    public function randomColor(){
        $length = 6;
        return substr(str_shuffle(str_repeat($x='0123456789abcdef', ceil($length/strlen($x)) )),1,$length);
    }

    //
    // генератор случайного timestamp (меньше текущей даты/времени)
    //
    public function generateTimestamp(){
        $year= mt_rand(2019, date("Y"));
        $month = $year == date("Y") ? mt_rand(1, (int)date("MM") + 1) : mt_rand(1, 12);
        if ($year == date("Y") && $month == (int)date("MM") + 1){
            $day = mt_rand(1, (int)date("d"));
        }
        else if ($month == 2) $day = mt_rand(1, 28);
        else $day = mt_rand(1, 30);

        $today = getdate();
        $hour = mt_rand(0, $today["hours"]);
        $min = mt_rand(0, $today["minutes"]);
        $sec = mt_rand(0, $today["seconds"]);

        $timeStr = "%s-%s-%s %s:%s:%s";
        return sprintf( $timeStr, $year,
            $this->numberFormat($month,2),
            $this->numberFormat($day,2),
            $this->numberFormat($hour,2),
            $this->numberFormat($min, 2),
            $this->numberFormat($sec,2));
    }


    function numberFormat($digit, $width) {
        while(strlen($digit) < $width)
            $digit = '0' . $digit;
        return $digit;
    }
}