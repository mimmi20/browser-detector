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
class LocalizeDate extends \Zend\Controller\Action\Helper\AbstractHelper
{
    /**
     * das locale Datumsformat
     */
    private $_localeDateFormat = 'dd.MM.y';

    /**
     *
     * @param   string|integer|\Zend\Date\Date|array $date
     *
     * @return  string
     */
    public function localizeDate($date)
    {
        $locale  = \Zend\Registry::get('\Zend\Locale\Locale')->toString();
        $options = array('locale' => $locale);

        if (\Zend\Date\Date::isDate($date, null, $locale)
            && \Zend\Locale\Locale_Format::checkDateFormat($date, $options)
        ) {
            $format     = \Zend\Locale\Locale_Format::getDateFormat($locale);
            $dateObject = new \Zend\Date\Date($date, null, $locale);

            $dateOptions = $dateObject->toArray();
            $dateOptions['year'] = \Zend\Date\Date::getFullYear($dateOptions['year']);

            $dateObject = new \Zend\Date\Date($dateOptions, null, $locale);
            return $dateObject->toString($format);
        }

        return null;
    }

    /**
     * Default-Methode für Services
     *
     * @param   string|integer|\Zend\Date\Date|array $date
     *
     * @return KreditCore_Controller_Helper_NormalizeLocalize
     */
    public function direct($date)
    {
        return $this->localizeDate($date);
    }
}