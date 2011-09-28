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
class GetJsFile extends GetFileAbstract
{
    /**
     * Strategy pattern: helper method to invoke
     *
     * @param string     $paid
     * @param string     $caid
     * @param string     $mode     e.g.: 'curl','fallback','ergebnis','calc'
     * @param string     $filename
     *
     * @return string
     */
    public function direct($paid = null, $caid = null, $mode = 'curl', $fileName = 'antrag1', $include = true)
    {
        $file = $this->view->getJsFileName($paid, $caid, $mode, $fileName);

        if ($include && $file != '') {
            return $this->includeFile($file, true, $paid, $caid, $mode);
        }

        return $file;
    }
}
