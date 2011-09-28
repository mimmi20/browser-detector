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
