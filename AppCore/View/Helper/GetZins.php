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
 * @version   SVN: $Id: GetZins.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * @category  Kreditrechner
 * @package   View_Helper
 */
class GetZins extends \Zend\View\Helper\AbstractHelper
{
    /**
     *
     * @param float|int|null    $zahl
     * @param int               $dezimal
     * @param string            $default    is returned if $zahl is null
     */
    public function getZins($resultSet = null)
    {
        $result  = '';
        $dezimal = 2;

        if ($resultSet->boni) {
            if ($resultSet->effZinsOben != $resultSet->effZinsUnten) {
                $result = $this->view->formatNumber($resultSet->effZinsUnten, $dezimal)
                        . '&nbsp;-&nbsp;'
                        . $this->view->formatNumber($resultSet->effZinsOben, $dezimal);
            } elseif ($resultSet->zinssatzIsCleaned) {
                $result = $this->view->formatNumber($resultSet->zinssatzCleaned, $dezimal);
            } else {
                $result = '<span class="ccAb">ab</span> '
                        . $this->view->formatNumber($resultSet->effZins, $dezimal);
            }
        } else {
            $result = $this->view->formatNumber($resultSet->effZins, $dezimal);
        }

        return $result . ' %';
    }
    
    /**
     * Strategy pattern: helper method to invoke
     *
     * @return mixed
     */
    public function direct($resultSet = null)
    {
        return $this->getZins($resultSet);
    }
}