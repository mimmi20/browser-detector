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
class Thunderbird
{
    protected $prefix = 'THUNDERBIRD';
    
    public function __construct($wurflContext, $userAgentNormalizer = null) 
    {
        parent::__construct($wurflContext, $userAgentNormalizer);
    }
    
    /**
     * Intercept all UAs Containing Thunderbird and are not mobile browsers
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent) 
    {
        if(WURFL_Handlers_Utils::isMobileBrowser($userAgent)) {
            return false;
        }
        return WURFL_Handlers_Utils::checkIfContains($userAgent, 'Thunderbird');
    }
    
    public function lookForMatchingUserAgent($userAgent)
    {//var_dump($userAgent);exit;
        return $this->applyRecoveryMatch($userAgent);
    }
    
    private $safaris = array(
        '' => 'thunderbird',
        '1.0' => 'thunderbird_1',
        '1.5' => 'thunderbird_1_5',
        '2.0' => 'thunderbird_2',
        '3.0' => 'thunderbird_3',
        '3.1' => 'thunderbird_3_1',
        '5.0' => 'thunderbird_5',
        '6.0' => 'thunderbird_6',
        '7.0' => 'thunderbird_7',
        '8.0' => 'thunderbird_8',
        '9.0' => 'thunderbird_9'
);
    
    public function applyRecoveryMatch($userAgent) 
    {
        $safariVersion = $this->safariVersion($userAgent);//var_dump($userAgent, $safariVersion);exit;
        $safariId = 'thunderbird';
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
    
    const SAFARI_VERSION_PATTERN = '/.*Thunderbird\/(\d+\.\d).*/';
    private function safariVersion($userAgent) 
    {
        if(preg_match(self::SAFARI_VERSION_PATTERN, $userAgent, $match)
) {
            return $match[1];
        }
        return NULL;
    }

}