<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Browser\Handlers;

/**
 * Copyright(c) 2011 ScientiaMobile, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or(at your option) any later version.
 *
 * Refer to the COPYING file distributed with this package.
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */

/**
 * CatchAllUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */

class Yahoofeedseeker extends Yahoo
{
    /**
     * Final Interceptor: Intercept
     * Everything that has not been trapped by a previous handler
     *
     * @param string $userAgent
     * @return boolean always true
     */
    public function canHandle($userAgent)
    {
        if ($this->utils->checkIfStartsWith($userAgent, 'Y!J SearchMonkey')
            || $this->utils->checkIfStartsWith($userAgent, 'Y!J-BRE')
            || $this->utils->checkIfStartsWith($userAgent, 'Y!J-BRG/GSC')
            || $this->utils->checkIfStartsWith($userAgent, 'Y!J-BRI')
            || $this->utils->checkIfStartsWith($userAgent, 'Y!J-BRO/YFSJ')
            || $this->utils->checkIfStartsWith($userAgent, 'Y!J-BRP/YFSBJ')
            || $this->utils->checkIfStartsWith($userAgent, 'Y!J-BRQ/DLCK')
            || $this->utils->checkIfStartsWith($userAgent, 'Y!J-BSC')
            || $this->utils->checkIfStartsWith($userAgent, 'Y!J-NSC')
            || $this->utils->checkIfStartsWith($userAgent, 'Y!J-PSC')
            || $this->utils->checkIfStartsWith($userAgent, 'Y!J-SRD')
            || $this->utils->checkIfStartsWith($userAgent, 'Y!J-VSC/ViSe')
            || $this->utils->checkIfStartsWith($userAgent, 'YahooFeedSeeker')
        ) {
            return true;
        }
        
        return false;
    }
    
    /**
     * detects the browser name from the given user agent
     *
     * @param string $userAgent
     *
     * @return string
     */
    protected function detectBrowser($userAgent)
    {
        return 'YahooFeedSeeker';
    }
    
    public function getWeight()
    {
        return 2;
    }
}