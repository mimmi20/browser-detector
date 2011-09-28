<?php
declare(ENCODING = 'utf-8');
namespace AppCore\Validator;

/**
 * geänderter Validator für Strings ohne Ziffern
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
class Alpha extends \Zend\Validator\Regex
{
    /**
     * Sets validator options
     *
     * @param  string $pattern
     * @return void
     */
    public function __construct($pattern = null)
    {
        parent::__construct('/[a-zA-Z -äöüÄÖÜß]/');
    }

    /**
     * Defined by \Zend\Validator\Interface
     *
     * Returns true if and only if $value matches against the pattern option
     *
     * @param  string $value
     * @return boolean
     */
    public function isValid($value)
    {
        if (is_int($value)
            || is_float($value)
            || is_numeric($value)
            || is_array($value)
        ) {
            $this->_error(self::INVALID);
            return false;
        }

        if (is_string($value) && '' == $value) {
            $this->_error(self::INVALID);
            return false;
        }

        return parent::isValid($value);
    }
}