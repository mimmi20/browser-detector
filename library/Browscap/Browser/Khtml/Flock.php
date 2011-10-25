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
 * FirefoxUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class WURFL_Handlers_FlockHandler extends WURFL_Handlers_Handler
{
    protected $prefix = 'FLOCK';
    
    public function __construct($wurflContext, $userAgentNormalizer = null)
    {
        parent::__construct($wurflContext, $userAgentNormalizer);
    }
    
    /**
     * Intercept all UAs Containing Flock and are not mobile browsers
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        if(WURFL_Handlers_Utils::isMobileBrowser($userAgent)) {
            return false;
        }
        return WURFL_Handlers_Utils::checkIfContains($userAgent, 'Flock');
    }
    
    public function lookForMatchingUserAgent($userAgent)
    {//var_dump($userAgent);exit;
        return $this->applyRecoveryMatch($userAgent);
    }
    private $safaris = array(
        '' => 'flock',
        '1.0' => 'flock_1',
        '1.2' => 'flock_1',
        '2.0' => 'flock_2',
        '2.5' => 'flock_2',
        '3.0' => 'flock_3',
        '3.1' => 'flock_3_1',
        '5.0' => 'flock_5'
);
    
    public function applyRecoveryMatch($userAgent)
    {
        $safariVersion = $this->safariVersion($userAgent);//var_dump($userAgent, $safariVersion);exit;
        $safariId = 'flock';
        if(isset($this->safaris[$safariVersion])) {
            return $this->safaris[$safariVersion];
        }
        return 'generic_web_browser';
        
    }
    
    const SAFARI_VERSION_PATTERN = '/.*Flock\/(\d+\.\d).*/';
    private function safariVersion($userAgent)
    {
        if(preg_match(self::SAFARI_VERSION_PATTERN, $userAgent, $match)
) {
            return $match[1];
        }
        return NULL;
    }

}