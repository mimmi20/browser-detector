<?php

class Unister_View_Helper_AppendUrlParams
{
    /**
     * URL Append custom parameters
     *
     * @return string
     */
    public function appendUrlParams(array $urlParams, $excludeParams=null)
    {
        $urlQueryParams = array();
        foreach ($urlParams as $urlKey => $urlVal) {
            /*
             * Skip empty keys
             */
            if ('' == $urlKey) {
                continue;
            }

            /**
             * Exclude some special params
             */
            if ($this->_isExcludeParam($urlKey, $excludeParams)) {
                continue;
            }

            /*
             * Build the query string
             */
            $urlQueryParams[]  = $urlKey . '='
                . rawurlencode( stripslashes($urlVal) );
        }

        return '?' . join('&', $urlQueryParams);
    }

    /**
     * Check if current parameter has to be skipped
     *
     * @param string $param
     * @param mixed $excludeParams
     * @return bool True if param should be skipped
     */
    protected function _isExcludeParam($param, $excludeParams)
    {
        if (is_string($excludeParams)) {
            if ($param == $excludeParams) {
                return true;
            }
        } elseif (is_array($excludeParams)) {
            if (in_array($param, $excludeParams)) {
                return true;
            }
        }

        return false;
    }
}
