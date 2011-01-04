<?php
declare(ENCODING = 'iso-8859-1');
namespace I18Nv2\DecoratedList;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

// +----------------------------------------------------------------------+
// | PEAR :: I18Nv2 :: DecoratedList :: Filter                            |
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
// $Id: Filter.php 5 2009-12-27 20:39:52Z tmu $

/**
 * I18Nv2::DecoratedList::Filter
 * 
 * @package     I18Nv2
 * @category    Internationalization
 */

require_once 'I18Nv2/DecoratedList.php';

/**
 * I18Nv2_DecoratedList_Filter
 * 
 * The Filter Decorator only operates on getAllCodes().
 *
 * @author      Michael Wallner <mike@php.net>
 * @version     $Revision: 5 $
 * @package     I18Nv2
 * @access      public
 */
class Filter extends \I18Nv2\DecoratedList
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
