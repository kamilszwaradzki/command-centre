<?php
namespace Utils;
class Date {
    public function getMonth($month, $year)
    {
        $list = array();
        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month) {
                $obj = new \stdClass();
                $obj->date = date('Y/m', $time);
                $obj->day = date('j', $time);
                $obj->dayOfWeek = date('N', $time);
                $list[] = $obj;
            }
        }
        return $list;
    }

    public function getCurrentMonth()
    {
        $month = intval(date('m'));
        $year = intval(date('Y'));
        return $this->getMonth($month, $year);
    }
}
