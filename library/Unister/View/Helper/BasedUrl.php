<?php

/** @see Zend_View_Helper_Abstract */
require_once 'Zend/View/Helper/Abstract.php';

/**
 *
 * @author a.hoffmann
 */
class Unister_View_Helper_BasedUrl extends Zend_View_Helper_Abstract
{
    /**
     * Returns site's base url, or file with base url prepended
     *
     * $file is appended to the base url for simplicity
     *
     * @param  array|string|null $file
     * @return string
     */
    public function basedUrl($file = null)
    {
        if (is_array($file)) {
            $file = $this->view->url($file, null, true, true);
        } else {
            $file = $this->view->baseUrl($file);
        }

        if (defined('HOME_URL')) {
            if (substr(HOME_URL, -1) == '/' && substr($file, 0, 1) == '/') {
                $file = substr($file, 1);
            }

            /** @see Zend_Controller_Front */
            require_once 'Zend/Controller/Front.php';
            $baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();

            $homeUrl = HOME_URL;
            if ($baseUrl && strpos($homeUrl, $baseUrl) !== false) {
                $homeUrl = str_replace($baseUrl, '', $homeUrl);
            }

            $file = $homeUrl . $file;
        }

        return $file;
    }
}