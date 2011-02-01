<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Validator;

/**
 * Validator für Dateinamen
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
class FileName extends \Zend\Validator\Regex
{
    /**
     * Sets validator options
     *
     * @param  string $pattern
     * @return void
     */
    public function __construct($pattern = null)
    {
        parent::__construct('/[a-zA-Z0-9 -äöüÄÖÜß._\/]/');
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
        if (is_array($value) || is_float($value)) {
            $this->_error(self::INVALID);
            return false;
        }

        if (is_numeric($value) && 0 >= (int) $value) {
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