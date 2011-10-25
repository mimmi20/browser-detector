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
 * SafariHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class WURFL_Handlers_SafariHandler extends WURFL_Handlers_Handler
{
    protected $prefix = 'SAFARI';
    
    public function __construct($wurflContext, $userAgentNormalizer = null)
    {
        parent::__construct($wurflContext, $userAgentNormalizer);
    }
    
    /**
     * Intercept all UAs Starting with Mozilla and Containing Safari and are not mobile browsers
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        if(WURFL_Handlers_Utils::isMobileBrowser($userAgent)) {
            return false;
        }
        
        return WURFL_Handlers_Utils::checkIfContains($userAgent, 'Safari');
    }
    
    public function lookForMatchingUserAgent($userAgent)
    {
        return $this->applyRecoveryMatch($userAgent);
    }
    private $safaris = array(
        '' => 'safari',
        '3.0' => 'safari_3_0',
        '3.1' => 'safari_3_1',
        '3.2' => 'safari_3_2',
        '4.0' => 'safari_4_0',
        '4.1' => 'safari_4_1',
        '5.0' => 'safari_5_0',
        '5.1' => 'safari_5_1',
        '55'  => 'safari_5_0',
        '65'  => 'safari_5_0',
        '75'  => 'safari_5_1'
);
    
    public function applyRecoveryMatch($userAgent)
    {
        $safariVersion = $this->safariVersion($userAgent);//var_dump($userAgent, $safariVersion);exit;
        $safariId = 'safari';
        if(isset($this->safaris[$safariVersion])) {
            return $this->safaris[$safariVersion];
        }
        /*
        //var_dump($userAgent, $safariVersion, $safariId);exit;
        if($this->isDeviceExist($safariId)) {
            return $safariId;
        }
        /**/
        return 'generic_web_browser';
        
    }
    
    const SAFARI_VERSION_PATTERN = '/.*Version\/(\d+\.\d+).*/';
    const SAFARI_VERSION_PATTERN_EXT = '/.*Safari\/(\d{2})\d{2}\..*/';
    private function safariVersion($userAgent)
    {
        if(WURFL_Handlers_Utils::checkIfStartsWith($userAgent, 'Mozilla') 
            && WURFL_Handlers_Utils::checkIfContains($userAgent, 'Safari') 
            && preg_match(self::SAFARI_VERSION_PATTERN, $userAgent, $match)
) {
            return $match[1];
        }
        if(WURFL_Handlers_Utils::checkIfContains($userAgent, 'Safari') 
            && preg_match(self::SAFARI_VERSION_PATTERN_EXT, $userAgent, $match)
) {
            return $match[1];
        }
        return NULL;
    }

}