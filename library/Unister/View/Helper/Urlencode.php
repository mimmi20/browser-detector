<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty urlencode modifier plugin
 *
 * Type:     modifier
 * Name:     urlencode
 * Purpose:  urlencoding
 * @link     ??
 * @param string
 * @return string
 */class Unister_View_Helper_Urlencode extends Zend_View_Helper_Abstract{
    public function urlencode($string)
    {
        return urlencode($string);
    }
}
/* vim: set expandtab: */