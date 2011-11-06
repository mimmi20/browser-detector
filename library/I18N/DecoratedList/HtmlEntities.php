<?php
declare(ENCODING = 'utf-8');
namespace I18N\DecoratedList;

// +----------------------------------------------------------------------+
// | PEAR :: I18N :: DecoratedList :: HtmlEntities                      |
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
// $Id$

/**
 * I18N_Decorator_HtmlEntities
 *
 * @author      Michael Wallner <mike@php.net>
 * @version     $Revision$
 * @package     I18N
 * @access      public
 */
class HtmlEntities extends \I18N\DecoratedList
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
            return htmlEntities($value, ENT_QUOTES, $this->list->getEncoding());
        } elseif (is_array($value)) {
            return array_map(array(&$this, 'decorate'), $value);
        }
        return $value;
    }
}
?>
