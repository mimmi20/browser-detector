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
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */

use Browscap\Browser\Handler as BrowserHandler;

/**
 * SamsungUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class Samsung extends BrowserHandler
{
    public function __construct($wurflContext, $userAgentNormalizer = null)
    {
        parent::__construct($wurflContext, $userAgentNormalizer);
    }
    
    /**
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent) {
        return $this->utils->checkIfContains($userAgent, 'Samsung/SGH')
                || $this->utils->checkIfStartsWithAnyOf($userAgent, array('SEC-','Samsung','SAMSUNG', 'SPH', 'SGH', 'SCH'));
    }


     /**
     * If UA starts with one of the following('SEC-', 'SAMSUNG-', 'SCH'), apply RIS with FS.
     * If UA starts with one of the following('Samsung-','SPH', 'SGH'), apply RIS with First Space(not FS).
     * If UA starts with 'SAMSUNG/', apply RIS with threshold SS(Second Slash)
     *
     * @param string $userAgent
     * @return string
     */
    public function lookForMatchingUserAgent($userAgent)
    {
        $tolerance = $this->tolerance($userAgent);
        $this->logger->log('$this->prefix :Applying Conclusive Match for ua: $userAgent with tolerance $tolerance');
        return $this->utils->risMatch(array_keys($this->userAgentsWithDeviceID), $userAgent, $tolerance);
    }

 
    private function tolerance($userAgent)
    {
        if($this->utils->checkIfStartsWithAnyOf($userAgent, array('SEC-', 'SAMSUNG-', 'SCH'))) {
            return $this->utils->firstSlash($userAgent);
        }
        if($this->utils->checkIfStartsWithAnyOf($userAgent, array('Samsung-','SPH', 'SGH'))) {
            return $this->utils->firstSpace($userAgent);
        }
        if($this->utils->checkIfStartsWith($userAgent, 'SAMSUNG/')) {
            return $this->utils->secondSlash($userAgent);
        }
        return $this->utils->firstSlash($userAgent);
    }

    protected $prefix = 'SAMSUNG';
}

