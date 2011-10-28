<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

require_once 'FormatNumber.php';

/**
 * Smarty date_format modifier plugin
 *
 * Type:     modifier<br />
 * Name:     date_format<br />
 * Purpose:  format datestamps via strftime<br />
 * Input:<br />
 *         - string: input date string
 *         - format: strftime format for output
 *         - default_date: default date if $string is empty
 * @link http://smarty.php.net/manual/en/language.modifier.date.format.php
 *          date_format (Smarty online manual)
 * @param string
 * @param string
 * @param string
 * @return string|void
 */class Unister_View_Helper_EuroFormat extends Unister_View_Helper_FormatNumber{
    public function euroFormat($zahl,$show_euro = 1,$swap_dot = 0,$dezimal = 2)
    {
        return parent::formatNumber($zahl,$swap_dot,$dezimal).(($show_euro) ? ' &euro;' : '');
    }
}
/* vim: set expandtab: */