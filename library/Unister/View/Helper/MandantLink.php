<?php

/**
 * View Helper to replace Zend_View_Helper_Url in an enviroment,
 * where the Application can be included as a cUrl-Request.
 *
 * If we detect a request during cUrl inclusion, we build a link
 * like a Get-Request. Is the Application called directly, we do not
 * bother and just give back a standart Url assembled by the
 * respective Router.
 *
 * @author a.hoffmann
 */
class Unister_View_Helper_MandantLink extends Zend_View_Helper_Url
{
    public function mandantLink(array $params, $module = 'default', $new = true)
    {
        if (App_Mandant::isMandant()) {
            $result = '?';

            //Match Controller and Action
            if (isset($params['controller'])) {
                $params['zvcontroller'] = $params['controller'];
                unset($params['controller']);
            }
            if (isset($params['action'])) {
                $params['zvaction'] = $params['action'];
                unset($params['action']);
            }

            //Parse Parameters into Get Query
            foreach((array)$params as $key => $value) {
                $result .= $key . '=' . $value . '&';
            }

            $result = trim($result, '&');
            return App_Mandant::getBaseUrl(false) . $result;
        } else {
            return parent::url($params, $module, $new);
        }
    }
}