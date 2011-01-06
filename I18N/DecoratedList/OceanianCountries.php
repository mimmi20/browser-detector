<?php
// +----------------------------------------------------------------------+
// | PEAR :: I18N :: DecoartedList :: OceanianCountries                 |
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
 * I18N::DecoratedList::OceanianCountries
 * 
 * @package     I18N
 * @category    Internationalization
 */

require_once 'I18N/DecoratedList/Filter.php';

/**
 * I18N_DecoratedList_OceanianCountries
 * 
 * Use only for decorating I18N_Country.
 *
 * @author      Michael Wallner <mike@php.net>
 * @version     $Revision$
 * @package     I18N
 * @access      public
 */
class I18N_DecoratedList_OceanianCountries extends I18N_DecoratedList_Filter
{
    /**
     * Keys for Oceanian countries
     * 
     * @var array
     */
    var $elements = array(
        'AU','FJ','KI','MH','FM','NR','NZ','PW','PG','WS','SB','TO','TV','VU'
    );
}
?>
