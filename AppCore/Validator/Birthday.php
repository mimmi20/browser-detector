<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Validator;

/**
 * Validator für Geburtsdaten
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
class Birthday extends Date
{
    const NOFUTUREDATE = 'noFuture';

    /**
     * Validation failure message key for when the value does not appear to be
     * a valid date
     */
    const INVALID = 'dateInvalid';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::NOFUTUREDATE => 'das Geburtsdatum kann nicht in der Zukunft
                               liegen',
        self::INVALID      => '\'%value%\' does not appear to be a valid date',
    );

    /**
     * Defined by \Zend\Validator\Interface
     *
     * Returns true if $value is a valid date of the format YYYY-MM-DD
     * If optional $format or $locale is set the date format is checked
     * according to \Zend\Date\Date, see \Zend\Date\Date::isDate()
     *
     * @param  string $value
     * @return boolean
     */
    public function isValid($value)
    {
        $valueString = (string) $value;
        $valueArray  = explode('.', $valueString);
        $nowArray    = explode('.', date('d.m.Y'));

        $this->_setValue($valueString);

        if (count($valueArray) != 3) {
            $this->_error(self::INVALID);
            return false;
        }

        // check for Empty
        $dateResult = parent::isValid($valueString);
        if (!$dateResult) {
            $this->_error(self::INVALID);

            // Get messages and errors from _dateValidator
            $messages = parent::getMessages();
            foreach ($messages as $code => $message) {
                $this->_messages[$code] = $message;
            }
            foreach (parent::getErrors() as $error) {
                $this->_errors[] = $error;
            }

            return false;
        }

        if ($valueArray[2] > $nowArray[2]) {
            $this->_error(self::NOFUTUREDATE);
            return false;
        }

        if ($valueArray[2] == $nowArray[2]
            && $valueArray[1] > $nowArray[1]
        ) {
            $this->_error(self::NOFUTUREDATE);
            return false;
        }

        if ($valueArray[2] == $nowArray[2]
            && $valueArray[1] == $nowArray[1]
            && $valueArray[0] > $nowArray[0]
        ) {
            $this->_error(self::NOFUTUREDATE);
            return false;
        }

        return true;
    }
}