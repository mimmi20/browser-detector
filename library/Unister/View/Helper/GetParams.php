<?php

class Unister_View_Helper_GetParams
{
    /**
     * Get controller params
     *
     * @return object
     */
    public function getParams()
    {
        $request = Zend_Controller_Front::getInstance()->getRequest();

        return (object) $request->getParams();
    }
}
