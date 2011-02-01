<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\View\Helper;

/**
 * @category  Kreditrechner
 * @package   View_Helper
 * @copyright 2007-2010 Unister GmbH
 * @author    Stefan Barthel <stefan.barthel@unister-gmbh.de>
 * @version   $Id$
 */

/**
 * @category  Kreditrechner
 * @package   View_Helper
 * @copyright 2007-2010 Unister GmbH
 */
class PercentageFormat extends \Zend\View\Helper\AbstractHelper
{
    /**
     *
     * @param float|int|null    $zahl
     * @param int               $dezimal
     * @param string            $default    is returned if $zahl is null
     */
    public function percentageFormat($zahl = 0, $dezimal = 2, $default = '-')
    {
        if ($zahl === null) {
            return $default;
        } else {
            return $this->view->formatNumber($zahl, $dezimal) . ' %';
        }
    }
    
    /**
     * Strategy pattern: helper method to invoke
     *
     * @return mixed
     */
    public function direct($zahl = 0, $dezimal = 2, $default = '-')
    {
        return $this->percentageFormat($zahl, $dezimal, $default);
    }
}