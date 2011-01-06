<?php
declare(ENCODING = 'iso-8859-1');
namespace I18N\DecoratedList;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

// +----------------------------------------------------------------------+
// | PEAR :: I18N :: DecoratedList :: Filter                            |
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
 * I18N::DecoratedList::Filter
 * 
 * @package     I18N
 * @category    Internationalization
 */

require_once 'I18N/DecoratedList.php';

/**
 * I18N_DecoratedList_Filter
 * 
 * The Filter Decorator only operates on getAllCodes().
 *
 * @author      Michael Wallner <mike@php.net>
 * @version     $Revision$
 * @package     I18N
 * @access      public
 */
class Filter extends \I18N\DecoratedList
{
    /**
     * Filter
     * 
     * exclude|include resp. false|true
     * 
     * @access  public
     * @var     mixed
     */
    public $filter = 'include';
    
    /**
     * Elements
     * 
     * Keys that should be filtered
     * 
     * @access  public
     * @var     array
     */
    public $elements = array();
    
    /** 
     * decorate
     * 
     * @access  protected
     * @return  mixed
     * @param   mixed   $value
     */
    protected function decorate($value)
    {
        if (is_array($value)) {
            $result = array();
            $filter = array_map(
                array(&$this->list, 'changeKeyCase'), 
                $this->elements
            );
            switch ($this->filter)
            {
                case false:
                case 'exclude':
                    foreach ($value as $key => $val) {
                        if (!in_array($key, $filter)) {
                            $result[$key] = $val;
                        }
                    }
                break;
                
                case 'include':
                case true:
                    foreach ($value as $key => $val) {
                        if (in_array($key, $filter)) {
                            $result[$key] = $val;
                        }
                    }
                break;
            }
            return $result;
        }
        return $value;
    }
}
