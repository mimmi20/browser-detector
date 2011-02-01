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
class GetCssFileName extends \Zend\View\Helper\AbstractHelper
{
    /**
     * Strategy pattern: helper method to invoke
     *
     * @param string     $paid
     * @param string     $caid
     * @param string     $mode     e.g.: 'curl','fallback','ergebnis','calc'
     * @param string     $filename
     *
     * @return mixed
     */
    public function direct($paid = null, $caid = null, $mode = 'curl', $fileName = 'antrag1')
    {
        $basePath    = HOME_PATH . DS . 'kampagne' . DS;
        $correctPath = DS . 'css' . DS . $mode . DS . $fileName . '.css';
        $filePath    = DS . 'css' . DS . $mode . DS . 'general.css';
        $generalPath = DS . 'css' . DS . 'general.css';

        $files = array(
            8 => $basePath . 'general' . $generalPath,
            6 => $basePath . $caid . $generalPath,
            5 => $basePath . 'general' . $filePath,
            3 => $basePath . $caid . $filePath,
            2 => $basePath . 'general' . $correctPath,
            0 => $basePath . $caid . $correctPath
        );

        if ($caid != $paid) {
            $files[7] = $basePath . $paid . $generalPath;
            $files[4] = $basePath . $paid . $filePath;
            $files[1] = $basePath . $paid . $correctPath;
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
