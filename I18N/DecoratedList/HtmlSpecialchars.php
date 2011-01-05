<?php
// +----------------------------------------------------------------------+
// | PEAR :: I18N :: DecoratedList :: HtmlSpecialchars                  |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is available at http://www.php.net/license/3_0.txt              |
// | If you did not receive a copy of the PHP license and are unable      |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Copyright (c) 2004 Michael Wallner <mike@iworks.at>                  |
// +----------------------------------------------------------------------+
//
// $Id: HtmlSpecialchars.php 5 2009-12-27 20:39:52Z tmu $

/**
 * I18N::DecoratedList::HtmlSpecialchars
 * 
 * @package     I18N
 * @category    Internationalization
 */

require_once 'I18N/DecoratedList.php';

/**
 * I18N_Decorator_HtmlSpecialchars
 * 
 * When you are going to serve XHTML as XML or XHTML+XML then you will get 
 * problems while displaying umlauts etc. as their HTML entities.
 *
 * @author      Michael Wallner <mike@php.net>
 * @version     $Revision: 5 $
 * @package     I18N
 * @access      public
 */
class I18N_DecoratedList_HtmlSpecialchars extends I18N_DecoratedList
{
    /** 
     * decorate
     * 
     * @access  protected
     * @return  mixed
     * @param   mixed   $value
     */
    function decorate($value)
    {
        if (is_string($value)) {
            return htmlSpecialchars($value, ENT_QUOTES, 
                $this->list->getEncoding());
        } elseif (is_array($value)) {
            return array_map(array(&$this, 'decorate'), $value);
        }
        return $value;
    }
}
?>
