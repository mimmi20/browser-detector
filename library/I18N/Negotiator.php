<?php
declare(ENCODING = 'utf-8');
namespace I18N;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

// +----------------------------------------------------------------------+
// | PEAR :: I18N :: Negotiator                                         |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is available at http://www.php.net/license/3_0.txt              |
// | If you did not receive a copy of the PHP license and are unable      |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Copyright (c) 2004 The Authors                                       |
// +----------------------------------------------------------------------+
// | Authors:   Naoki Shima <murahachibu@php.net>                         |
// |            Wolfram Kriesing <wk@visionp.de>                          |
// |            Michael Wallner <mike@iworks.at>                          |
// +----------------------------------------------------------------------+
//
// $Id$

/**
 * I18N::Negotiator
 *
 * @package      I18N
 * @category     Internationalization
 */

/**
 * I18N_Negotiator
 * 
 * @author      Naoki Shima <murahachibu@php.net>
 * @author      Wolfram Kriesing <wk@visionp.de>
 * @author      Michael Wallner <mike@php.net>
 * @version     $Revision$
 * @access      public
 * @package     I18N
 */
class Negotiator
{
    /**
     * I18N_Language
     * 
     * @var     object
     */
    public $I18NLang = null;
    
    /**
     * I18N_Country
     * 
     * @var     object
     */
    public $I18NCountry = null;
    
    /**
     * Save default country code.
     *
     * @var     string
     */
    private $_defaultCountry;

    /**
     * Save default language code.
     *
     * @var     string
     */
    private $_defaultLanguage;

    /**
     * Save default encoding code.
     *
     * @var     string
     */
    private $_defaultEncoding;

    /**
     * Save default content type.
     *
     * @var     string
     */
    private $_defaultType;

    /**
     * HTTP_ACCEPT_CHARSET
     * 
     * @var     array
     */
    private $_acceptEncoding = array();
    
    /**
     * HTTP_ACCEPT_LANGUAGE
     * 
     * @var     array
     */
    private $_acceptLanguage = array();

    /**
     * HTTP_ACCEPT
     * 
     * @var     array
     */
    private $_acceptType = array();
    
    /**
     * Language variations
     * 
     * @var     array
     */
    private $_langVariation = array();
    
    /**
     * Countries
     * 
     * @var     array
     */
    private $_country = array();
    
    /**
     * ZE2 Constructor
     * @ignore
     */
    public function __construct($defaultEncoding = 'iso-8859-1', $defaultType = 'text/html')
    {
        $this->_defaultEncoding = $defaultEncoding;
        $this->_defaultType     = $defaultType;
        
        $this->_negotiateEncoding();
        $this->_negotiateType();
    }
    
    /**
     * Negotiate Encoding
     *
     * @return  void
     */
    private function _negotiateEncoding()
    {
        if (!isset($_SERVER['HTTP_ACCEPT_CHARSET'])) {
            return;
        }
        foreach (explode(',', $_SERVER['HTTP_ACCEPT_CHARSET']) as $encoding) {
            if (!empty($encoding)) {
                $this->_acceptEncoding[] = preg_replace('/;.*/', '', $encoding);
            }
        }
    }
    
    /**
     * Negotiate the Content Type
     *
     * @return  void
     */
    private function _negotiateType()
    {
        if (!isset($_SERVER['HTTP_ACCEPT'])) {
            return;
        }
        foreach (explode(',', $_SERVER['HTTP_ACCEPT']) as $type) {
            if (!empty($type)) {
                $this->_acceptType[] = preg_replace('/;.*/', '', $type);
            }
        }
        //var_dump($this->_acceptType);
    }

    /**
     * Find Encoding match
     * 
     * @return  string
     * @param   array   $encodings
     */
    public function getEncodingMatch($encodings = null)
    {
        $match = $this->_getMatch(
            (is_array($encodings) ? $encodings : array()), 
            $this->_acceptEncoding, 
            $this->_defaultEncoding
        );
        
        return strtolower($match);
    }

    /**
     * Find Content type match
     *
     * @return  string
     * @param   array   $types
     */
    public function getTypeMatch(array $types = array())
    {
        $match = $this->_getMatch(
            (is_array($types) ? $types : array()), 
            $this->_acceptType,
            $this->_defaultType
        );
        
        return strtolower($match);
    }
    
    /**
     * Return first matched value from first and second parameter.
     * If there is no match found, then return third parameter.
     * 
     * @return  string
     * @param   array   $needle
     * @param   array   $haystack
     * @param   string  $default
     */
    private function _getMatch(array $needle, array $haystack, $default = '')
    {
        if (!$haystack) {
            return $default;
        }
        if (!$needle) {
            return current($haystack);
        }
        
        if ($result = current($a = array_intersect($needle, $haystack))) {
            return $result;
        }
        return $default;
    }
}