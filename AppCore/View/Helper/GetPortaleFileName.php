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
class GetPortaleFileName extends \Zend\View\Helper\AbstractHelper
{
    /**
     * Strategy pattern: helper method to invoke
     *
     * @return mixed
     */
    public function direct($paid = null, $caid = null, $mode = 'js', $fileName = 'js')
    {
        $front     = \Zend\Controller\Front::getInstance();
        $basePath  = 'partials' . DS . 'portale' . DS;

        $file = $caid . DS . $fileName . DS . $mode . '.phtml';
        //$logger->info($file);

        if (!file_exists($basePath . $file)) {
            $file = $caid . DS . $fileName . '.phtml';
        }
        //$logger->info($file);

        if ($caid != $paid && !file_exists($basePath . $file)) {
            $file = $paid . DS . $fileName . DS . $mode . '.phtml';
        }
        //$logger->info($file);

        if ($caid != $paid && !file_exists($basePath . $file)) {
            $file = $paid . DS . $fileName . '.phtml';
        }
        //$logger->info($file);

        if (!file_exists($basePath . $file)) {
            $file = 'general' . DS . $fileName . DS . $mode . '.phtml';
        }
        //$logger->info($file);

        if (!file_exists($basePath . $file)) {
            $file = 'general' . DS . $fileName . '.phtml';
        }
        //$logger->info($file);

        return $basePath . $file;
    }
}
