<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\View\Helper;

/**
 * View-Helper
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   View_Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
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
    public function direct($resultSet = null)
    {
        $result  = '';
        $dezimal = 2;

        if ($resultSet['boni']) {
            if ($resultSet['effZinsOben'] != $resultSet['effZinsUnten']) {
                $result = $this->view->getHelper('formatNumber')->direct($resultSet['effZinsUnten'], $dezimal)
                        . '&nbsp;-&nbsp;'
                        . $this->view->getHelper('formatNumber')->direct($resultSet['effZinsOben'], $dezimal);
            } elseif ($resultSet['zinssatzIsCleaned']) {
                $result = $this->view->getHelper('formatNumber')->direct($resultSet['zinssatzCleaned'], $dezimal);
            } else {
                $result = '<span class="ccAb">ab</span> '
                        . $this->view->getHelper('formatNumber')->direct($resultSet['effZins'], $dezimal);
            }
        } else {
            $result = $this->view->getHelper('formatNumber')->direct($resultSet['effZins'], $dezimal);
        }

        return $result . ' %';
    }
}