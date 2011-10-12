<?php
/**
* $Id$
* @author <mishal(@)centrum.cz>
*/

$this->dateFormats = array(
    I18N_DATETIME_SHORT     =>  '%d.%m.%y',
    I18N_DATETIME_DEFAULT   =>  '%d.%m.%Y',
    I18N_DATETIME_MEDIUM    =>  '%d %b %Y',
    I18N_DATETIME_LONG      =>  '%d %B %Y',
    I18N_DATETIME_FULL      =>  '%A, %d %B %Y'
);
$this->timeFormats = array(
    I18N_DATETIME_SHORT     =>  '%H:%M',
    I18N_DATETIME_DEFAULT   =>  '%H:%M:%S',
    I18N_DATETIME_MEDIUM    =>  '%H:%M:%S',
    I18N_DATETIME_LONG      =>  '%H:%M:%S %Z',
    I18N_DATETIME_FULL      =>  '%H:%M hod. %Z'
);

$this->currencyFormats[I18N_CURRENCY_LOCAL][0] = 'Kè';
$this->currencyFormats[I18N_CURRENCY_LOCAL][1] = '2';
$this->currencyFormats[I18N_CURRENCY_LOCAL][2] = ',';
$this->currencyFormats[I18N_CURRENCY_LOCAL][3] = '.';
$this->currencyFormats[I18N_CURRENCY_INTERNATIONAL][0] = 'CZK';
$this->currencyFormats[I18N_CURRENCY_INTERNATIONAL][1] = '2';
$this->currencyFormats[I18N_CURRENCY_INTERNATIONAL][2] = '.';
$this->currencyFormats[I18N_CURRENCY_INTERNATIONAL][3] = ',';

?>
