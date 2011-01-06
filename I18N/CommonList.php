<?php
declare(ENCODING = 'iso-8859-1');
namespace I18N;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

// +----------------------------------------------------------------------+
// | PEAR :: I18N :: CommonList                                         |
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
 * I18N::CommonList
 *
 * @author      Michael Wallner <mike@php.net>
 * @package     I18N
 * @category    Internationalization
 */

/**
 * I18N_CommonList
 *
 * Base class for I18N_Country and I18N_Language that performs some basic
 * work, so code doesn't get written twice or even more often in the future.
 *
 * @author      Michael Wallner <mike@php.net>
 * @version     $Revision$
 * @access      public
 */
class CommonList
{
    /**
     * Codes
     *
     * @access  protected
     * @var     array
     */
    protected $codes = array();

    /**
     * Language
     *
     * @access  protected
     * @var     string
     */
    protected $language = '';

    /**
     * Encoding
     *
     * @access  protected
     * @var     string
     */
    protected $encoding = '';

    /**
     * Constructor
     *
     * @access  public
     * @param   string  $language
     * @param   string  $encoding
     */
    public function __construct($language = null, $encoding = null)
    {
        if (!$this->setLanguage($language)) {
            if (class_exists('I18N')) {
                $l = \I18N::lastLocale(0, true);
                if (!isset($l) || !$this->setLanguage($l['language'])) {
                    $this->setLanguage('en');
                }
            } else {
                $this->setLanguage('en');
            }
        }
        if (!$this->setEncoding($encoding)) {
            $this->setEncoding('UTF-8');
        }
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
    public function setLanguage($language)
    {
        if (!isset($language)) {
            return false;
        }
        $language = strToLower($language);
        if ($language === $this->language) {
            return true;
        }
        if ($this->loadLanguage($language)) {
            $this->language = $language;
            return true;
        }
        return false;
    }

    /**
     * Get current language
     *
     * @access  public
     * @return  string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set active encoding
     *
     * @access  public
     * @return  bool
     * @param   string  $encoding
     */
    public function setEncoding($encoding)
    {
        if (!isset($encoding)) {
            return false;
        }
        $this->encoding = strToUpper($encoding);
        return true;
    }

    /**
     * Get current encoding
     *
     * @access  public
     * @return  string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * Check if code is valid
     *
     * @access  public
     * @return  bool
     * @param   string  $code   code
     */
    public function isValidCode($code)
    {
        return isset($this->codes[$this->changeKeyCase($code)]);
    }

    /**
     * Return corresponding name of code
     *
     * @access  public
     * @return  string  name
     * @param   string  $code   code
     */
    public function getName($code)
    {
        $code = $this->changeKeyCase($code);
        if (!isset($this->codes[$code])) {
            return '';
        }
        if ('UTF-8' !== $this->encoding) {
            return iconv('UTF-8', $this->encoding .'//TRANSLIT', $this->codes[$code]);
        }
        return $this->codes[$code];
    }

    /**
     * Return all the codes
     *
     * @access  public
     * @return  array   all codes as associative array
     */
    public function getAllCodes()
    {
        if ('UTF-8' !== $this->encoding) {
            $codes = $this->codes;
            array_walk($codes, array($this, '_iconv'));
            return $codes;
        }
        return $this->codes;
    }

    /**
     * @access  private
     * @return  void
     */
    private function _iconv($code, $key)
    {
        $code = iconv('UTF-8', $this->encoding .'//TRANSLIT', $code);
    }

    /**
     * Load Language
     *
     * @access  proteceted
     * @return  bool
     * @param   string  $language
     */
    protected function loadLanguage($language)
    {
        return false;
    }

    /**
     * Change Key Case
     *
     * @access  protected
     * @return  string
     * @param   string  $code
     */
    protected function changeKeyCase($code)
    {
        return $code;
    }

    /**
     * Decorate this list
     *
     * @access  public
     * @return  object  I18N_DecoratedList
     * @param   string  $type
     */
    public function toDecoratedList($type)
    {
        $decoratedList = '\\I18N\\DecoratedList\\' . $type;
        return new $decoratedList($this);
    }
}