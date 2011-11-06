<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Browser\Gecko;

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
 * FirefoxUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class Seamonkey extends BrowserHandler
{
    protected $prefix = 'SEAMONKEY';
    
    public function __construct($wurflContext, $userAgentNormalizer = null)
    {
        parent::__construct($wurflContext, $userAgentNormalizer);
    }
    
    /**
     * Intercept all UAs Containing Seamonkey and are not mobile browsers
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        if(WURFL_Handlers_Utils::isMobileBrowser($userAgent)) {
            return false;
        }
        return WURFL_Handlers_Utils::checkIfContains($userAgent, 'SeaMonkey');
    }
    
    private $chromes = array(
        '' => 'seamonkey',
        '1.0' => 'seamonkey_1',
        '1.1' => 'seamonkey_1_1',
        '2.0' => 'seamonkey_2',
        '2.1' => 'seamonkey_2_1',
        '2.2' => 'seamonkey_2_2',
        '2.3' => 'seamonkey_2_3',
        '2.4' => 'seamonkey_2_4',
        '2.5' => 'seamonkey_2_5',
        '2.6' => 'seamonkey_2_6',
);
    
    public function lookForMatchingUserAgent($userAgent)
    {
        return $this->applyRecoveryMatch($userAgent);
    }
    
    public function applyRecoveryMatch($userAgent)
    {
        $chromeVersion = $this->chromeVersion($userAgent);
        $chromeId = 'seamonkey';
        if(isset($this->chromes[$chromeVersion])) {
            return $this->chromes[$chromeVersion];
        }
        
        return 'generic_web_browser';
        
    }
    
    const CHROME_VERSION_PATTERN = '/.*SeaMonkey\/(\d+\.\d).*/';
    private function chromeVersion($userAgent)
    {
        if(preg_match(self::CHROME_VERSION_PATTERN, $userAgent, $match)) {
            return $match[1];
        }
        return '';
    }
    /**/

}