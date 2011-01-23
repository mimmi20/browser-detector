<?php
declare(ENCODING = 'iso-8859-1');
namespace Credit\Core\View\Helper;

/**
 * View-Helper
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   View_Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: EuroFormat.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * @category  Kreditrechner
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