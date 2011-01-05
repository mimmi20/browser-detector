<?php
/**
* $Id: da.php 5 2009-12-27 20:39:52Z tmu $
*/

$this->dateFormats = array(
    I18N_DATETIME_SHORT     =>  '%e/%m-%y',
    I18N_DATETIME_DEFAULT   =>  '%d-%b-%Y',
    I18N_DATETIME_MEDIUM    =>  '%d-%b-%Y',
    I18N_DATETIME_LONG      =>  '%e. %B %Y',
    I18N_DATETIME_FULL      =>  '%A, d. %e. %B Y'
);
$this->timeFormats = array(
    I18N_DATETIME_SHORT     =>  'H:i',
    I18N_DATETIME_DEFAULT   =>  '%H:%M:%S',
    I18N_DATETIME_MEDIUM    =>  '%H:%M:%S',
    I18N_DATETIME_LONG      =>  '%H:%M:%S %Z',
    I18N_DATETIME_FULL      =>  'kl. %H:%M'
);      
?>
