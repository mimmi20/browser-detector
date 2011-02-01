<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Validator;

/**
 * Validator f�r Postleitzahlen
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Validate
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * @category   Kreditrechner
 * @package    Validate
 */
class Plz extends \Zend\Validator\AbstractValidator
{
    const INVALID = 'plzInvalid';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID => "'%value%' ist keine Postleitzahl"
    );

    /**
     * Local object for validating if empty
     *
     * @var \Zend\Validator\NotEmpty
     */
    private $_emptyValidator;

    /**
     * Local object for validating the integer
     *
     * @var \Zend\Validator\Int
     */
    private $_intValidator;

    /**
     * Local object for validating the length
     *
     * @var \Zend\Validator\StringLength
     */
    private $_lengthValidator;

    private $_validators = array();

    /**
     * Instantiates hostname validator for local use
     *
     * You can pass a bitfield to determine what types of hostnames are
     * allowed.
     * These bitfields are defined by the ALLOW_* constants in
     * \Zend\Validator\Hostname
     * The default is to allow DNS hostnames only
     *
     * @param integer                $allow             OPTIONAL
     * @param bool                   $validateMx        OPTIONAL
     * @param \Zend\Validator\Hostname $hostnameValidator OPTIONAL
     * @return void
     */
    public function __construct()
    {
        $this->_emptyValidator  = new \Zend\Validator\NotEmpty();
        $this->_intValidator    = new \Zend\Validator\Int();
        $this->_lengthValidator = new \Zend\Validator\StringLength(5, 5);

        $this->_validators = array(
            $this->_emptyValidator,
            $this->_intValidator,
            $this->_lengthValidator
        );
    }

    /**
     * Defined by \Zend\Validator\Interface
     *
     * Returns true if and only if $value is a valid email address
     * according to RFC2822
     *
     * @param  string $value
     * @return boolean
     */
    public function isValid($value)
    {
        if ((is_string($value) && '' == $value)
            || !is_numeric($value)
            || is_array($value)
        ) {
            $this->_error(self::INVALID);
            return false;
        }

        $valueString = (string) $value;
        $this->_setValue($valueString);

        foreach ($this->_validators as $validator) {
            $result = $validator->isValid($valueString);

            if (!$result) {
                $this->_error(self::INVALID);

                // Get messages and errors from validator
                $messages = $validator->getMessages();
                foreach ($messages as $code => $message) {
                    $this->_messages[$code] = $message;
                }
                foreach ($validator->getErrors() as $error) {
                    $this->_errors[] = $error;
                }

                return false;
            }
        }

        return true;
    }
}