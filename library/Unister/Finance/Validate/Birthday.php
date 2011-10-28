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
 * @version    $Id: Birthday.php 13 2011-01-06 21:27:04Z tmu $
 */

/**
 * @see Zend_Validate_Date
 */
require_once LIB_PATH . 'Unister' . DS . 'Finance' . DS . 'Validate' . DS . 'Date.php';

/**
 * @category   Zend
 * @package    Zend_Validate
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Unister_Finance_Validate_Birthday extends Zend_Validate_Abstract
{
    const NOFUTUREDATE = 'noFuture';

    /**
     * Validation failure message key for when the value does not appear to be a valid date
     */
    const INVALID = 'dateInvalid';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::NOFUTUREDATE => "das Geburtsdatum kann nicht in der Zukunft liegen",
        self::INVALID      => "'%value%' does not appear to be a valid date",
    );

    /**
     * Local object for date validating
     *
     * @var Zend_Validate_Date
     */
    private $_dateValidator;

    /**
     * Sets validator options
     *
     * @param  string             $format OPTIONAL
     * @param  string|Zend_Locale $locale OPTIONAL
     * @return void
     */
    public function __construct($format = 'd.m.Y', $locale = null)
    {
        $this->_dateValidator  = new Unister_Finance_Validate_Date();
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
        $nowArray    = explode('.', date("d.m.Y"));

        $this->_setValue($valueString);

        if (count($valueArray) != 3) {
            $this->_error(self::INVALID);
            return false;
        }

    // check for Empty
        $dateResult = $this->_dateValidator->isValid($valueString);
        if (!$dateResult) {
            $this->_error(self::INVALID);

            // Get messages and errors from _dateValidator
            foreach ($this->_dateValidator->getMessages() as $code => $message) {
                $this->_messages[$code] = $message;
            }
            foreach ($this->_dateValidator->getErrors() as $error) {
                $this->_errors[] = $error;
            }

            return false;
        }

        if ($valueArray[2] > $nowArray[2]) {
            $this->_error(self::NOFUTUREDATE);
            return false;
        }

        if ($valueArray[2] == $nowArray[2] && $valueArray[1] > $nowArray[1]) {
            $this->_error(self::NOFUTUREDATE);
            return false;
        }

        if ($valueArray[2] == $nowArray[2] && $valueArray[1] == $nowArray[1] && $valueArray[0] > $nowArray[0]) {
            $this->_error(self::NOFUTUREDATE);
            return false;
        }

        return parent::isValid($value);
    }
}