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
 * @version   SVN: $Id: MultiCheckbox.php 3966 2010-10-25 04:59:52Z t.mueller $
 */

/**
 * Form_Element
 *
 * @category  Kreditrechner
 * @package   Form
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditCore_Class_Form_Element_MultiCheckbox
    extends Zend_Form_Element_MultiCheckbox
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