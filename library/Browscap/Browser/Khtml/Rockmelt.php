<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Browser\Khtml;

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
 * ChromeUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class Rockmelt
{
    protected $prefix = 'ROCKMELT';
    
    public function __construct($wurflContext, $userAgentNormalizer = null)
    {
        parent::__construct($wurflContext, $userAgentNormalizer);
    }
    
    /**
     * Intercept all UAs Containing Chrome and are not mobile browsers
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        if(WURFL_Handlers_Utils::isMobileBrowser($userAgent)) {
            return false;
        }
        return WURFL_Handlers_Utils::checkIfContains($userAgent, 'RockMelt')
            && WURFL_Handlers_Utils::checkIfContains($userAgent, 'Chrome');
    }
    
    private $chromes = array(
        '' => 'rockmelt',
        '0.9' => 'rockmelt_0_9',
        '1.0' => 'rockmelt_1'
);
    
    public function lookForMatchingUserAgent($userAgent)
    {
        return $this->applyRecoveryMatch($userAgent);
    }
    
    public function applyRecoveryMatch($userAgent)
    {
        $chromeVersion = $this->chromeVersion($userAgent);
        $chromeId = 'rockmelt';
        //var_dump($userAgent, $chromeVersion);exit;
        if(isset($this->chromes[$chromeVersion])) {
            return $this->chromes[$chromeVersion];
        }
        
        /*
        if($this->isDeviceExist($chromeId)) {
            return $chromeId;
        }
        /**/
        return 'generic_web_browser';
        
    }
    
    const CHROME_VERSION_PATTERN = '/.*RockMelt\/(\d+\.\d).*/';
    private function chromeVersion($userAgent)
    {
        if(preg_match(self::CHROME_VERSION_PATTERN, $userAgent, $match)) {
            return $match[1];
        }
        return NULL;
    }
}