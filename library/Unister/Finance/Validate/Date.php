<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Validate
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Date.php 13 2011-01-06 21:27:04Z tmu $
 */

/**
 * @see Zend_Validate_Date
 */
require_once LIB_PATH . 'Zend' . DS . 'Validate' . DS . 'Date.php';

/**
 * @category   Zend
 * @package    Zend_Validate
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Unister_Finance_Validate_Date extends Zend_Validate_Date
{
    /**
     * Sets validator options
     *
     * @param  string             $format OPTIONAL
     * @param  string|Zend_Locale $locale OPTIONAL
     * @return void
     */
    public function __construct($format = 'd.m.Y', $locale = null)
    {
        parent::__construct($format, $locale);
    }

    /**
     * Defined by Zend_Validate_Interface
     *
     * Returns true if $value is a valid date of the format YYYY-MM-DD
     * If optional $format or $locale is set the date format is checked
     * according to Zend_Date, see Zend_Date::isDate()
     *
     * @param  string $value
     * @return boolean
     */
    public function isValid($value)
    {
        $valueString = (string) $value;
        $valueArray  = explode('.', $valueString);

        $this->_setValue($valueString);

        if (count($valueArray) != 3) {
            $this->_error(self::INVALID);
            return false;
        }

        if ($valueArray[0] < 0 || $valueArray[1] < 0 || $valueArray[1] > 12 || $valueArray[0] > 31) {
            $this->_error(self::INVALID);
            return false;
        }

        if ($valueArray[1] == 2 && $valueArray[0] > 29) {
            $this->_error(self::INVALID);
            return false;
        }

        if ($valueArray[0] == 31 && ($valueArray[1] == 4 || $valueArray[1] == 6 || $valueArray[1] == 9 || $valueArray[1] == 11)) {
            $this->_error(self::INVALID);
            return false;
        }

        if ($valueArray[0] == 29 && $valueArray[1] == 2 && ((($valueArray[2] % 4) != 0 || (($valueArray[2] % 100) == 0 && ($valueArray[2] % 400) != 0)))) {
            $this->_error(self::INVALID);
            return false;
        }

        return parent::isValid($value);
    }
}