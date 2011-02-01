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
class FormatNumber extends \Zend\View\Helper\AbstractHelper
{
    /**
     * Strategy pattern: helper method to invoke
     *
     * Formats $zahl to localized settings.
     *
     * For example: '3.000,50' becomes '3000.50'
     *
     * @param float|int         $zahl
     * @param int               $decimal
     *
     * @return string
     */
    public function direct($zahl = 0, $dezimal = 2)
    {
        if (!$zahl || intval($zahl) == 0) {
            $korrekt = 0;
            $dezimal = 2;
        } else {
            $korrekt = $zahl;
            $korrekt = str_replace(',', '', $korrekt);
            //$korrekt = str_replace('.', ',', $korrekt);
        }

        return number_format($korrekt, $dezimal, ',', '.');
    }
}
