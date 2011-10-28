<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty capitalize modifier plugin
 *
 * Type:     modifier<br>
 * Name:     capitalize<br>
 * Purpose:  capitalize words in the string
 * @link http://smarty.php.net/manual/en/language.modifiers.php#LANGUAGE.MODIFIER.CAPITALIZE
 *      capitalize (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @return string
 */class Unister_View_Helper_Capitalize extends Zend_View_Helper_Abstract{
    public function capitalize($string, $uc_digits = false)
    {
        $this->ucfirst(null, $uc_digits);
        return preg_replace_callback('!\'?\b\w(\w|\')*\b!', array($this, 'ucfirst'), $string);
    }

    protected function ucfirst($string, $uc_digits = null)
    {
        static $_uc_digits = false;
        
        if(isset($uc_digits)) {
            $_uc_digits = $uc_digits;
            return;
        }
        
        if(substr($string[0],0,1) != "'" && !preg_match("!\d!",$string[0]) || $_uc_digits)
            return ucfirst($string[0]);
        else
            return $string[0];
    }
}