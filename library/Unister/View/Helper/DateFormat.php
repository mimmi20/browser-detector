<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

require_once LIB_PATH . 'Unister' . DS . 'View' . DS . 'Helper' . DS . 'MakeTimestamp.php';

/**
 * Smarty date_format modifier plugin
 *
 * Type:     modifier<br>
 * Name:     date_format<br>
 * Purpose:  format datestamps via strftime<br>
 * Input:<br>
 *         - string: input date string
 *         - format: strftime format for output
 *         - default_date: default date if $string is empty
 * @link http://smarty.php.net/manual/en/language.modifier.date.format.php
 *          date_format (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param string
 * @param string
 * @return string|void
 * @uses smarty_make_timestamp()
 */
class Unister_View_Helper_DateFormat extends Zend_View_Helper_Abstract
{
    public function dateFormat($string, $format = '%b %e, %Y', $default_date = '')
    {
        $timeStamp = new Unister_View_Helper_MakeTimestamp();

        if ($string != '') {
            $timestamp = $timeStamp->makeTimestamp($string);
        } elseif ($default_date != '') {
            $timestamp = $timeStamp->makeTimestamp($default_date);
        } else {
            return;
        }
        if (DIRECTORY_SEPARATOR == '\\') {
            $_win_from = array('%D',       '%h', '%n', '%r',          '%R',    '%t', '%T');
            $_win_to   = array('%m/%d/%y', '%b', "\n", '%I:%M:%S %p', '%H:%M', "\t", '%H:%M:%S');
            if (strpos($format, '%e') !== false) {
                $_win_from[] = '%e';
                $_win_to[]   = sprintf('%\' 2d', date('j', $timestamp));
            }
            if (strpos($format, '%l') !== false) {
                $_win_from[] = '%l';
                $_win_to[]   = sprintf('%\' 2d', date('h', $timestamp));
            }
            $format = str_replace($_win_from, $_win_to, $format);
        }
        return strftime($format, $timestamp);
    }
}
/* vim: set expandtab: */