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
 * @version   SVN: $Id: GetJsFileName.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * @category  Kreditrechner
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
