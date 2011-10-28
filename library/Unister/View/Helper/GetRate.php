<?php

class Unister_View_Helper_GetRate
{
    /**
     * Get formatted currency string
     *
     * @return string
     */
    public function getRate($val)
    {
        $currency = new Zend_Currency('de_DE');

        return  str_replace('€', '&euro;', $currency->toCurrency($val)) ;
    }
}
