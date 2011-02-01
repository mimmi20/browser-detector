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
class NormalizeDate extends \Zend\Controller\Action\Helper\AbstractHelper
{
    /**
     * das locale Datumsformat
     */
    private $_localeDateFormat = 'dd.MM.yyyy';

    /**
     * Normalize date for database usage
     *
     * @param   string|integer|\Zend\Date\Date|array  $date
     * @return  string
     */
    public function normalizeDate($date)
    {
        $locale  = \Zend\Registry::get('\Zend\Locale\Locale')->toString();
        $options = array(
            'date_format' => $this->_localeDateFormat,
            'locale'      => $locale
        );

        if (\Zend\Date\Date::isDate($date, $this->_localeDateFormat, $locale)
            && \Zend\Locale\Locale_Format::checkDateFormat($date, $options)
        ) {
            $dateOptions = \Zend\Locale\Locale_Format::getDate($date, $options);

            $dateOptions['year'] = \Zend\Date\Date::getFullYear($dateOptions['year']);

            // Detect date or time input
            $dateObject = new \Zend\Date\Date($dateOptions);
            return $dateObject->toString('yyyy-MM-dd');
        }

        return null;
    }

    /**
     * Default-Methode für Services
     *
     * @return KreditCore_Controller_Helper_NormalizeLocalize
     * @access public
     */
    public function direct($date)
    {
        return $this->normalizeDate($date);
    }
}