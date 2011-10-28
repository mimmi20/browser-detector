<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty lower modifier plugin
 *
 * Type:     modifier<br>
 * Name:     lower<br>
 * Purpose:  convert string to lowercase
 * @link http://smarty.php.net/manual/en/language.modifier.lower.php
 *          lower (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @return string
 */class Unister_View_Helper_Utf8decode extends Zend_View_Helper_Abstract{
    public function utf8decode($string)
    {
        if (is_string($string) && $string != '') {
            if (mb_detect_encoding($string . ' ','UTF-8,ISO-8859-1') == 'UTF-8') {                $string = utf8_decode($string);
            }
        }                return $string;
    }
}