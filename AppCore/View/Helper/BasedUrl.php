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
 * @version   SVN: $Id: BasedUrl.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * @category  Kreditrechner
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