<?php


namespace App\Services;



use Illuminate\Support\Carbon;

class DateService implements Interfaces\DateServiceInterface
{
    /**
     * @return array
     */
    public function getAllFullTextMonth()
    {
        $month = [];
        for($m=1; $m<=12; ++$m){
            $month[$m] = $this->formatMonthToFullTextMonth($m);
        }
        return $month;
    }

    /**
     * @param int $month
     * @return string
     */
    public function getFullTextMonth(int $month)
    {
        return $this->formatMonthToFullTextMonth($month);
    }

    /**
     * @param int $month
     * @return string
     */
    private function formatMonthToFullTextMonth(int $month)
    {
        return Carbon::createFromFormat('m', $month)->translatedFormat('F');
    }
}
