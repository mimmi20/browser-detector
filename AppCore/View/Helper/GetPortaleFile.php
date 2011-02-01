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
