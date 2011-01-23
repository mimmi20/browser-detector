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
 * @version   SVN: $Id: GetJsFile.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * @category  Kreditrechner
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
