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
 * @version    $Id: Plz.php 13 2011-01-06 21:27:04Z tmu $
 */

/**
 * @see Zend_Validate_Abstract
 */
require_once LIB_PATH . 'Zend/Validate/Abstract.php';

/**
 * @see Zend_Validate_StringLength
 */
require_once LIB_PATH . 'Zend/Validate/StringLength.php';

/**
 * @see Zend_Validate_Int
 */
require_once LIB_PATH . 'Zend/Validate/Int.php';

/**
 * @category   Zend
 * @package    Zend_Validate
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Unister_Finance_Validate_Plz extends Zend_Validate_Abstract
{
    const INVALID = 'plzInvalid';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID => "'%value%' ist keine Postleitzahl",
    );

    /**
     * Local object for validating if empty
     *
     * @var Zend_Validate_NotEmpty
     */
    private $_emptyValidator;

    /**
     * Local object for validating the integer
     *
     * @var Zend_Validate_Int
     */
    private $_intValidator;

    /**
     * Local object for validating the length
     *
     * @var Zend_Validate_StringLength
     */
    private $_lengthValidator;

    /**
     * Instantiates hostname validator for local use
     *
     * You can pass a bitfield to determine what types of hostnames are allowed.
     * These bitfields are defined by the ALLOW_* constants in Zend_Validate_Hostname
     * The default is to allow DNS hostnames only
     *
     * @param integer                $allow             OPTIONAL
     * @param bool                   $validateMx        OPTIONAL
     * @param Zend_Validate_Hostname $hostnameValidator OPTIONAL
     * @return void
     */
    public function __construct()
    {
        $this->_emptyValidator  = new Zend_Validate_NotEmpty();
        $this->_intValidator    = new Zend_Validate_Int();
        $this->_lengthValidator = new Zend_Validate_StringLength(5, 5, ENCODING);
    }

    /**
     * Defined by Zend_Validate_Interface
     *
     * Returns true if and only if $value is a valid email address
     * according to RFC2822
     *
     * @link   http://www.ietf.org/rfc/rfc2822.txt RFC2822
     * @link   http://www.columbia.edu/kermit/ascii.html US-ASCII characters
     * @param  string $value
     * @return boolean
     */
    public function isValid($value)
    {
        $valueString = (string) $value;
        $matches     = array();
        $length      = true;

        $this->_setValue($valueString);

        // check for Empty
        $emptyResult = $this->_emptyValidator->isValid($value);
        if (!$emptyResult) {
            $this->_error(self::INVALID);

            // Get messages and errors from _emptyValidator
            foreach ($this->_emptyValidator->getMessages() as $code => $message) {
                $this->_messages[$code] = $message;
            }
            foreach ($this->_emptyValidator->getErrors() as $error) {
                $this->_errors[] = $error;
            }

            return false;
        }

        // check for Integer
        $intResult = $this->_intValidator->isValid($value);
        if (!$intResult) {
            $this->_error(self::INVALID);

            // Get messages and errors from _intValidator
            foreach ($this->_intValidator->getMessages() as $code => $message) {
                $this->_messages[$code] = $message;
            }
            foreach ($this->_intValidator->getErrors() as $error) {
                $this->_errors[] = $error;
            }

            return false;
        }

        // check for Integer
        $lngthResult = $this->_lengthValidator->isValid($value);
        if (!$lngthResult) {
            $this->_error(self::INVALID);

            // Get messages and errors from _lengthValidator
            foreach ($this->_lengthValidator->getMessages() as $code => $message) {
                $this->_messages[$code] = $message;
            }
            foreach ($this->_lengthValidator->getErrors() as $error) {
                $this->_errors[] = $error;
            }

            return false;
        }

        return true;
    }
}
