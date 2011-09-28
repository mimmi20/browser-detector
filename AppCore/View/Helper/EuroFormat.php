<?php
declare(ENCODING = 'utf-8');
namespace AppCore\View\Helper;

/**
 * View-Helper
 *
 * PHP version 5
 *
 * @category  CreditCalc
 * @package   View_Helper
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * @category  CreditCalc
 * @package   View_Helper
 */
class EuroFormat extends \Zend\View\Helper\AbstractHelper
{
    /**
     * @param float|int|null    $zahl
     * @param int               $dezimal
     * @param string            $default    is returned if $zahl is null
     *
     * @return string
     */
    public function direct($zahl = 0, $dezimal = 2, $default = '-')
    {
        return (is_null($zahl) || !is_object($this->view)) 
            ? $default
            : $this->view->formatNumber($zahl, $dezimal) . ' &euro;';
    }
}