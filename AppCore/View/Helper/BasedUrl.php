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
 * @author    a.hoffmann
 */
class BasedUrl extends \Zend\View\Helper\AbstractHelper
{
    /**
     * Strategy pattern: helper method to invoke
     *
     * @return mixed
     */
    public function direct($file = null)
    {
        if (is_array($file)) {
            $helperUrl = new \Zend\View\Helper\Url();
            $file      = $helperUrl->direct($file, null, true, true);
        } else {
            $helperBaseUrl = new \Zend\View\Helper\BaseUrl();
            $file          = $helperBaseUrl->direct($file);
        }

        $homeUrl = \Zend\Registry::get('_home');

        if (substr($homeUrl, -1) == '/' && substr($file, 0, 1) == '/') {
            $file = substr($file, 1);
        }

        /** @see \Zend\Controller\Front */
        $baseUrl = \Zend\Controller\Front::getInstance()->getBaseUrl();

        if ($baseUrl && strpos($homeUrl, $baseUrl) !== false) {
            $homeUrl = str_replace($baseUrl, '', $homeUrl);
        }

        $file = $homeUrl . $file;

        return $file;
    }
}