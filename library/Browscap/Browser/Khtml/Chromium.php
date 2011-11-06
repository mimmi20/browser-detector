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

use Browscap\Browser\Handler as BrowserHandler;

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
class Chromium extends BrowserHandler
{
    protected $prefix = 'CHROMIUM';
    
    public function __construct($wurflContext, $userAgentNormalizer = null)
    {
        parent::__construct($wurflContext, $userAgentNormalizer);
    }
    
    /**
     * Intercept all UAs Containing Chromium and are not mobile browsers
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        if(WURFL_Handlers_Utils::isMobileBrowser($userAgent)) {
            return false;
        }
        return WURFL_Handlers_Utils::checkIfContains($userAgent, 'Chromium')
            && WURFL_Handlers_Utils::checkIfContains($userAgent, 'Chrome');
    }
    
    private $chromes = array(
        '' => 'chromium',
        '1' => 'chromium_1',
        '2' => 'chromium_2',
        '3' => 'chromium_3',
        '4' => 'chromium_4',
        '5' => 'chromium_5',
        '6' => 'chromium_6',
        '7' => 'chromium_7',
        '8' => 'chromium_8',
        '9' => 'chromium_9',
        '10' => 'chromium_10',
        '11' => 'chromium_11',
        '12' => 'chromium_12',
        '13' => 'chromium_13',
        '14' => 'chromium_14',
        '15' => 'chromium_15',
        '16' => 'chromium_16',
        '17' => 'chromium_17',
        '18' => 'chromium_18',
        '19' => 'chromium_19'
);
    
    public function lookForMatchingUserAgent($userAgent)
    {
        return $this->applyRecoveryMatch($userAgent);
    }
    
    public function applyRecoveryMatch($userAgent)
    {
        $chromeVersion = $this->chromeVersion($userAgent);
        $chromeId = 'chromium';
        if(isset($this->chromes[$chromeVersion])) {
            return $this->chromes[$chromeVersion];
        }
        
        return 'generic_web_browser';
        
    }
    
    const CHROME_VERSION_PATTERN = '/.*Chromium\/(\d+).*/';
    private function chromeVersion($userAgent)
    {
        if(preg_match(self::CHROME_VERSION_PATTERN, $userAgent, $match)) {
            return $match[1];
        }
        return '';
    }
    /**/
}