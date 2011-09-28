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
class GetPortaleFile extends GetFileAbstract
{
    /**
     * Strategy pattern: helper method to invoke
     *
     * @return mixed
     */
    public function direct($paid = null, $caid = null, $mode = 'js', $fileName = 'js', $include = false)
    {
        $file = $this->view->getPortaleFileName($paid, $caid, $mode, $fileName);
        if (!$include) {
            return $file;
        }

        return $this->includeFile($file, $include, $paid, $caid, $mode);
    }
}
