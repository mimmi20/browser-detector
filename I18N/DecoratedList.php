<?php
declare(ENCODING = 'utf-8');
namespace I18N;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

// +----------------------------------------------------------------------+
// | PEAR :: I18N :: DecoratedList                                      |
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
 * I18N::DecoratedList
 * 
 * Decorator for I18N_CommonList objects.
 * 
 * @package     I18N
 * @category    Internationalization
 */

/**
 * I18N_DecoratedList
 *
 * @author      Michael Wallner <mike@php.net>
 * @version     $Revision$
 * @package     I18N
 * @access      public
 */
class DecoratedList
{
    /**
     * I18N_(Common|Decorated)List
     * 
     * @access  protected
     * @var     object
     */
    var $list = null;
    
    /**
     * Constructor
     * 
     * @access  public
     * @param   object  $list   I18N_DecoratedList or I18N_CommonList
     */
    function __construct($list)
    {
        if (is_a($list, 'I18N_CommonList') ||
            is_a($list, 'I18N_DecoratedList')) {
            $this->list = $list;
        }
    }

    /** 
     * Get all codes
     * 
     * @access  public
     * @return  array
     */
    function getAllCodes()
    {
        return $this->decorate($this->list->getAllCodes());
    }
    
    /** 
     * Check if code is valid
     * 
     * @access  public
     * @return  bool
     * @param   string  $code
     */
    function isValidCode($code)
    {
        return $this->decorate($this->list->isValidCode($code));
    }
    
    /** 
     * Get name for code
     * 
     * @access  public
     * @return  string
     * @param   string  $code
     */
    function getName($code)
    {
        return $this->decorate($this->list->getName($code));
    }
    
    /**
     * Decorate
     * 
     * @abstract
     * @access  protected
     * @return  mixed
     * @param   mixed   $value
     */
    function decorate($value)
    {
        return $value;
    }

    /**
     * Decorate this list
     *
     * @access  public
     * @return  object  I18N_DecoratedList
     * @param   string  $type
     */
    function toDecoratedList($type)
    {
        $decoratedList = '\\I18N\\DecoratedList\\' . $type;
        return new $decoratedList($this);
    }

    /**
     * Change Key Case
     *
     * @access  protected
     * @return  string
     * @param   string  $code
     */
    function changeKeyCase($code)
    {
        return $this->list->changeKeyCase($code);
    }

    /**
     * Set active language
     * 
     * Note that each time you set a different language the corresponding
     * language file has to be loaded again, too.
     *
     * @access  public
     * @return  bool
     * @param   string  $language
     */
    function setLanguage($language)
    {
        return $this->list->setLanguage($language);
    }
    
    /**
     * Get current language
     * 
     * @access  public
     * @return  string
     */
    function getLanguage()
    {
        return $this->list->getLanguage();
    }
    
    /**
     * Set active encoding
     *
     * @access  public
     * @return  bool
     * @param   string  $encoding
     */
    function setEncoding($encoding)
    {
        return $this->list->setEncoding($encoding);
    }
    
    /** 
     * Get current encoding
     * 
     * @access  public
     * @return  string
     */
    function getEncoding()
    {
        return $this->list->getEncoding();
    }
}