<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Validator;

/**
 * geänderter Validator für alphanumerische Strings
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
class Alnum extends \Zend\Validator\Regex
{
    /**
     * Sets validator options
     *
     * @param  string $pattern
     * @return void
     */
    public function __construct($pattern = null)
    {
        parent::__construct('/[a-zA-Z -äöüÄÖÜß0-9]*/');
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
        if ((is_string($value) && '' == $value)
            || is_array($value)
        ) {
            $this->_error(self::INVALID);
            return false;
        }

        return parent::isValid($value);
    }
}