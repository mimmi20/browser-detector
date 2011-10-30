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
 * @version    $Id$
 */

/**
 * @see Zend_Validate_Abstract
 */
require_once LIB_PATH . 'Zend/Validate/Abstract.php';

/**
 * @see Zend_Validate_NotEmpty
 */
require_once LIB_PATH . 'Zend/Validate/NotEmpty.php';

/**
 * @see Zend_Validate_Alpha
 */
require_once LIB_PATH . 'Unister/Finance/Validate/Alpha.php';

/**
 * @category   Zend
 * @package    Zend_Validate
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Unister_Finance_Validate_Ort extends Zend_Validate_Abstract
{
    const INVALID  = 'ortInvalid';
    const NOTFOUND = 'ortNotFound';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID => "'%value%' ist kein Ort",
        self::NOTFOUND => "'%value%' ist kein bekannter Ortsname",
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
     * @var Zend_Validate_Alpha
     */
    private $_nameValidator;

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
        $this->_emptyValidator = new Zend_Validate_NotEmpty();
        $this->_nameValidator  = new Unister_Finance_Validate_Alpha();
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

        // check for Name
        $nameResult = $this->_nameValidator->isValid($value);
        if (!$nameResult) {
            $this->_error(self::INVALID);

            // Get messages and errors from _nameValidator
            foreach ($this->_nameValidator->getMessages() as $code => $message) {
                $this->_messages[$code] = $message;
            }
            foreach ($this->_nameValidator->getErrors() as $error) {
                $this->_errors[] = $error;
            }

            return false;
        }

        return true;
    }
}
