<?php
/**
 *
 * @author a.hoffmann
 * @deprecated Use MandantLink instead!
 */
class Unister_View_Helper_FormAction extends Zend_View_Helper_Abstract
{

    /**
     * !! DEPRECATED !!
     * @param $params
     * @return unknown_type
     */
    public function formAction($params)
    {
        $params = '/' . trim($params, '/');

        if (App_Mandant::isMandant()) {
            unset($params);
        }

        return App_Mandant::getBaseUrl() . $params;
    }
}