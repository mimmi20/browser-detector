<?php
/**
 * Form_Element
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Form
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Text.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Form_Element
 *
 * @category  Kreditrechner
 * @package   Form
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditCore_Class_Form_Element_Text
    extends Zend_Form_Element_Text
{
    /**
     * Overwrite setName method to allow square brackets
     *
     * @param string $name the element name
     *
     * @return Zend_Form_Element
     */
    public function setName($name)
    {
        $name = $this->filterName($name, true);

        if ('' === $name) {
            throw new Zend_Form_Exception(
                'Invalid name provided; ' .
                'must contain only valid variable characters and be non-empty'
            );
        }

        $this->_name = $name;

        return $this;
    }
}