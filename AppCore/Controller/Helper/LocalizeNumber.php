<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Controller\Helper;

/**
 * Normalisierer und Localisierer
 *
 * PHP version 5
 *
 * @category    Kreditrechner
 * @package     Controller-Helper
 * @copyright   Copyright (c) 2010 Unister GmbH
 * @author      Stefan Barthel <stefan.barthel@unister-gmbh.de>
 * @version     $Id$
 */

/**
 *
 * @category    Kreditrechner
 * @package     Controller-Helper
 * @copyright   Copyright (c) 2010 Unister GmbH
 */
class LocalizeNumber extends \Zend\Controller\Action\Helper\AbstractHelper
{
    /**
     * Contains the options used by Zend_Filters
     *
     * @var array
     */
    private $_options = array('number_format' => '#.00');

    /**
     *
     * @param int|float   $number
     *
     * @return int|float
     */
    public function localizeNumber($number)
    {
        if (!is_numeric($number)) {
            return null;
        }
        
        if (\Zend\Locale\Locale_Format::isNumber($number, $this->_options)) {
            return \Zend\Locale\Locale_Format::toNumber($number);
        }

        return null;
    }

    /**
     * Default-Methode für Services
     *
     * @param int|float   $number
     *
     * @return int|float
     */
    public function direct($number)
    {
        return $this->localizeNumber($number);
    }
}