<?php
declare(ENCODING = 'iso-8859-1');
namespace I18Nv2;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

// +----------------------------------------------------------------------+
// | PEAR :: I18Nv2 :: Negotiator                                         |
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
// $Id: Negotiator.php 5 2009-12-27 20:39:52Z tmu $

/**
 * I18Nv2::Negotiator
 *
 * @package      I18Nv2
 * @category     Internationalization
 */

/**
 * I18Nv2_Negotiator
 * 
 * @author      Naoki Shima <murahachibu@php.net>
 * @author      Wolfram Kriesing <wk@visionp.de>
 * @author      Michael Wallner <mike@php.net>
 * @version     $Revision: 5 $
 * @access      public
 * @package     I18Nv2
 */
class Negotiator
{
    /**
     * I18Nv2_Language
     * 
     * @var     object
     */
    public $I18NLang = null;
    
    /**
     * I18Nv2_Country
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
    public function __construct($defaultLanguage = 'en', $defaultEncoding = 'iso-8859-1', $defaultCountry = '', $defaultType = 'text/html')
    {
        $this->_defaultCountry  = $defaultCountry;
        $this->_defaultLanguage = $defaultLanguage;
        $this->_defaultEncoding = $defaultEncoding;
        $this->_defaultType     = $defaultType;
        
        $this->_negotiateLanguage();
        $this->_negotiateEncoding();
        $this->_negotiateType();
    }
    
    /**
     * Negotiate Language
     *
     * @return  void
     */
    private function _negotiateLanguage()
    {
        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return;
        }
        foreach(explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']) as $lang) {
            // Cut off any q-value that might come after a semi-colon
            if ($pos = strpos($lang, ';')) {
                $lang = trim(substr($lang, 0, $pos));
            }
            if (strstr($lang, '-')) {
                list($pri, $sub) = explode('-', $lang);
                if ($pri == 'i') {
                    /**
                    * Language not listed in ISO 639 that are not variants
                    * of any listed language, which can be registerd with the
                    * i-prefix, such as i-cherokee
                    */
                    $lang = $sub;
                } else {
                    $lang = $pri;
                    $this->singleI18NCountry();
                    if ($this->I18NCountry->isValidCode($sub)) {
                        $this->_country[$lang][] = strtoupper($sub);
                    } else { 
                        $this->_langVariation[$lang][] = $sub;
                    }
                }
            }
            $this->_acceptLanguage[] = $lang;
        }
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
     * Negotiate Encoding
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
     * Find Country Match
     *
     * @return  array
     * @param   string  $lang
     * @param   array   $countries
     */
    public function getCountryMatch($lang, $countries = null)
    {
        return $this->_getMatch(
            (is_array($countries) ? $countries : array()),
            @$this->_country[$lang],
            $this->_defaultCountry
        );
    }
 
    /**
     * Return variant info for passed parameter.
     *
     * @return  string
     * @param   string  $lang
     */
    public function getVariantInfo($lang)
    {
        return isset($this->_langVariation[$lang]) ? $this->_langVariation[$lang] : null;
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
     * Find Language match
     *
     * @return  string
     * @param   array   $langs
     */
    public function getLanguageMatch($langs = null)
    {
        $match = $this->_getMatch(
            (is_array($langs) ? $langs : array()), 
            $this->_acceptLanguage,
            $this->_defaultLanguage
        );
        
        return strtolower($match);
    }
    
    /**
     * Find locale match
     *
     * @return  string
     * @param   array   $langs
     * @param   array   $countries
     */
    public function getLocaleMatch($langs = null, $countries = null)
    {
        $lang = $this->_getMatch(
            (is_array($langs) ? $langs : array()), 
            $this->_acceptLanguage, 
            $this->_defaultLanguage
        );
        $ctry = $this->_getMatch(
            (is_array($countries) ? $countries : array()), 
            @$this->_country[$lang], 
            $this->_defaultCountry
        );
        return strtolower($lang) . ($ctry ? '_' . strtoupper($ctry) : '');
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
    
    /**
     * Find Country name for country code passed 
     * 
     * @return  void
     * @param   string  $code   country code
     */
    private function getCountryName($code)
    {
        $this->singleI18NCountry();
        return $this->I18NCountry->getName($code);
    }

    /**
     * Find Country name for country code passed 
     * 
     * @return  void
     * @param   string      $code   language code
     */
    private function getLanguageName($code)
    {
        $this->singleI18NLanguage();
        return $this->I18NLang->getName($code);
    }

    /**
     * Create the Language helper object
     * 
     * @return  object
     */
    private function singleI18NLanguage()
    {
        if (!isset($this->I18NLang)) {
            $this->I18NLang = new Language(
                $this->_defaultLanguage, 
                $this->_defaultEncoding
            );
        }
        return $this->I18NLang;
    }

    /**
     * Create the Country helper object
     * 
     * @return  object
     */
    public function singleI18NCountry()
    {
        if (!isset($this->I18NCountry)) {
            $this->I18NCountry = new Country(
                $this->_defaultLanguage,
                $this->_defaultEncoding
            );
        }
        return $this->I18NCountry;
    }
}