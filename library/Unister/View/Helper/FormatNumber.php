<?php

class Unister_View_Helper_FormatNumber
{
    /**
     * Get formatted number
     *
     * @return string
     */
    public function formatNumber($zahl,$swap_dot = 0,$dezimal = 2)
    {
        //return number_format($val, 2, ',', '.');
        if (!$zahl || intval($zahl) == 0) {
            $korrekt = 0;
            $dezimal = 2;
        } else {
            $korrekt = $zahl;
            if ($swap_dot) {
                $korrekt = str_replace(',','',$korrekt);
                $korrekt = str_replace('.',',',$korrekt);
            }
         }
         return number_format($korrekt,$dezimal,',','.');
    }
}
