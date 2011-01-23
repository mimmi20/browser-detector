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
 * @version   SVN: $Id: GetInstituteFileName.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * @category  Kreditrechner
 * @package   View_Helper
 */
class GetInstituteFileName extends \Zend\View\Helper\AbstractHelper
{
    /**
     * Strategy pattern: helper method to invoke
     *
     * @return mixed
     */
    public function direct($sparte = 'Kredit', $institut = '', $mode = 'js', $product = '')
    {
        $basePath = 'partials' . DS . 'institutes' . DS;

        $file = $basePath . $institut . DS . $sparte . DS . $mode . DS
              . $product . '.phtml';

        if (!file_exists($file)) {
            $file = $basePath . $institut . DS . $sparte . DS
                  . $product . '.phtml';
        }

        if (!file_exists($file)) {
            $file = $basePath . $institut . DS . $sparte . '.phtml';
        }

        if (!file_exists($file)) {
            $file = $basePath . 'general' . DS . $sparte . '.phtml';
        }

        return $file;
    }
}
