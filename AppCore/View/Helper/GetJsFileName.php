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
class GetJsFileName extends \Zend\View\Helper\AbstractHelper
{
    /**
     * Strategy pattern: helper method to invoke
     *
     * @return string
     */
    public function direct($paid = null, $caid = null, $mode = 'curl', $fileName = 'antrag1')
    {
        $basePath = HOME_PATH . DS . 'kampagne' . DS;
        $filePath = DS . 'js' . DS . $mode . DS . $fileName . '.js';

        $files = array(
            0 => $basePath . $caid . $filePath,
            2 => $basePath . 'general' . $filePath
        );

        if ($caid != $paid) {
            $files[1] = $basePath . $paid . $filePath;
        }

        ksort($files);

        foreach ($files as $file) {
            if (file_exists($file)) {
                return $file;
            }
        }

        return '';
    }
}
