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
class WURFL_Handlers_IronHandler extends WURFL_Handlers_Handler
{
    protected $prefix = 'IRON';
    
    public function __construct($wurflContext, $userAgentNormalizer = null)
    {
        parent::__construct($wurflContext, $userAgentNormalizer);
    }
    
    /**
     * Intercept all UAs Containing Iron and are not mobile browsers
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        if(WURFL_Handlers_Utils::isMobileBrowser($userAgent)) {
            return false;
        }
        return WURFL_Handlers_Utils::checkIfContains($userAgent, 'Iron');
    }
    
    private $chromes = array(
        '' => 'iron',
        '1' => 'iron_1',
        '2' => 'iron_2',
        '3' => 'iron_3',
        '4' => 'iron_4',
        '5' => 'iron_5',
        '6' => 'iron_6',
        '7' => 'iron_7',
        '8' => 'iron_8',
        '9' => 'iron_9',
        '10' => 'iron_10',
        '11' => 'iron_11',
        '12' => 'iron_12',
        '13' => 'iron_13',
        '14' => 'iron_14',
        '15' => 'iron_15',
        '16' => 'iron_16',
        '17' => 'iron_17',
        '18' => 'iron_18',
        '19' => 'iron_19'
);
    
    public function lookForMatchingUserAgent($userAgent)
    {
        return $this->applyRecoveryMatch($userAgent);
    }
    
    public function applyRecoveryMatch($userAgent)
    {
        $chromeVersion = $this->chromeVersion($userAgent);
        $chromeId = 'iron';
        if(isset($this->chromes[$chromeVersion])) {
            return $this->chromes[$chromeVersion];
        }
        
        return 'generic_web_browser';
        
    }
    
    const CHROME_VERSION_PATTERN = '/.*Iron\/(\d+).*/';
    private function chromeVersion($userAgent)
    {
        if(preg_match(self::CHROME_VERSION_PATTERN, $userAgent, $match)) {
            return $match[1];
        }
        return NULL;
    }
    /**/
}