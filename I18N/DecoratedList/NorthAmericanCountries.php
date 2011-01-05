<?php
// +----------------------------------------------------------------------+
// | PEAR :: I18N :: DecoartedList :: NorthAmericanCountries            |
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
// $Id: NorthAmericanCountries.php 5 2009-12-27 20:39:52Z tmu $

/**
 * I18N::DecoratedList::NorthAmericanCountries
 * 
 * @package     I18N
 * @category    Internationalization
 */

require_once 'I18N/DecoratedList/Filter.php';

/**
 * I18N_DecoratedList_NorthAmericanCountries
 * 
 * Use only for decorating I18N_Country.
 *
 * @author      Michael Wallner <mike@php.net>
 * @version     $Revision: 5 $
 * @package     I18N
 * @access      public
 */
class I18N_DecoratedList_NorthAmericanCountries extends I18N_DecoratedList_Filter
{
    /**
     * Keys for NorthAmerican countries
     * 
     * @var array
     */
    var $elements = array(
        'AG','BS','BB','BZ','CA','CR','CU','DM','SV','GD','GT','HT','HN','JM',
        'MX','NI','PA','KN','LC','VC','TT','US'
    );
}
?>
