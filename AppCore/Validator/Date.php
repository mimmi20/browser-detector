<?php
declare(ENCODING = 'utf-8');
namespace AppCore\Validator;

/**
 * geänderter Validator für Datumsangaben
 *
 * PHP version 5
 *
 * @category  CreditCalc
 * @package   Validate
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * @category   Kreditrechner
 * @package    Validate
 */
class Date extends \Zend\Validator\Date
{
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

        $this->_setValue($valueString);

        if (count($valueArray) != 3) {
            $this->_error(self::INVALID);
            return false;
        }

        if ($valueArray[0] < 0
            || $valueArray[1] < 0
            || $valueArray[1] > 12
            || $valueArray[0] > 31
        ) {
            $this->_error(self::INVALID);
            return false;
        }

        if ($valueArray[1] == 2 && $valueArray[0] > 29) {
            $this->_error(self::INVALID);
            return false;
        }

        if ($valueArray[0] == 31
            && ($valueArray[1] == 4
            || $valueArray[1] == 6
            || $valueArray[1] == 9
            || $valueArray[1] == 11)
        ) {
            $this->_error(self::INVALID);
            return false;
        }

        if ($valueArray[0] == 29
            && $valueArray[1] == 2
            && ((($valueArray[2] % 4) != 0
            || (($valueArray[2] % 100) == 0
            && ($valueArray[2] % 400) != 0)))
        ) {
            $this->_error(self::INVALID);
            return false;
        }

        return parent::isValid($value);
    }
}