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
 * @version   SVN: $Id: GetFileAbstract.php 30 2011-01-06 21:58:02Z tmu $
 * @abstract
 */

/**
 * @category  Kreditrechner
 * @package   View_Helper
 * @abstract
 */
abstract class GetFileAbstract extends \Zend\View\Helper\AbstractHelper
{
    /**
     * reads a file and includes its content
     *
     * @param string|array $files
     * @param boolean      $include
     * @param string       $paid
     * @param string       $caid
     * @param string       $mode
     *
     * @return string
     */
    protected function includeFile(
        $files, $include = false, $paid = '', $caid = '', $mode = '')
    {
        if ($include) {
            $content = $this->view->includeFile($files, $paid, $caid, $mode);

            return $content;
        } else {
            return $files;
        }
    }
}
