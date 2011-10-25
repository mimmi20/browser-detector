<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Browser\Presto;

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
 * OperaHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class WURFL_Handlers_OperaHandler extends WURFL_Handlers_Handler
{
    protected $prefix = 'OPERA';
    
    public function __construct($wurflContext, $userAgentNormalizer = null)
    {
        parent::__construct($wurflContext, $userAgentNormalizer);
    }
    
    /**
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        if(WURFL_Handlers_Utils::isMobileBrowser($userAgent)) {
            return false;
        }
        
        return WURFL_Handlers_Utils::checkIfContains($userAgent, 'Opera');
    }
    
    private $operas = array(
        '' => 'opera',
        '2.0' => 'opera_02_00',
        '2.1' => 'opera_02_10',
        '3.0' => 'opera_03_00',
        '3.5' => 'opera_03_50',
        '3.6' => 'opera_03_60',
        '4.0' => 'opera_04_00',
        '5.0' => 'opera_05_00',
        '6.0' => 'opera_06_00',
        '7.0' => 'opera_07_00',
        '8.0' => 'opera_08_00',
        '8.5' => 'opera_08_50',
        '9.0' => 'opera_09_00',
        '9.2' => 'opera_09_20',
        '9.5' => 'opera_09_50',
        '9.6' => 'opera_09_60',
        '10.0' => 'opera_10_00',
        '10.1' => 'opera_10_10',
        '10.5' => 'opera_10_50',
        '10.6' => 'opera_10_60',
        '10.7' => 'opera_10_70',
        '11.0' => 'opera_11_00',
        '11.1' => 'opera_11_10',
        '11.5' => 'opera_11_50',
        '12.0' => 'opera_12_00'
);
    
    const OPERA_TOLERANCE = 3;
    public function lookForMatchingUserAgent($userAgent)
    {
        return WURFL_Handlers_Utils::ldMatch(array_keys($this->userAgentsWithDeviceID), $userAgent, self::OPERA_TOLERANCE);
    }
    
    public function applyRecoveryMatch($userAgent)
    {
        $operaVersion = $this->operaVersion($userAgent);
        $operaId = 'opera';
        if(isset($this->operas[$operaVersion])) {
            $operaId = $this->operas[$operaVersion];
        }
        
        if($this->isDeviceExist($operaId)) {
            return $operaId;
        }

        
        return 'generic_web_browser';
        
    }
    

    
    const OPERA_VERSION_PATTERN = '/.*Opera[\s\/](\d+\.\d).*/';
    const OPERA_VERSION_PATTERN_EXT = '/.*Version\/(\d+\.\d).*/';
    private function operaVersion($userAgent)
    {
        if(WURFL_Handlers_Utils::checkIfStartsWith($userAgent, 'Opera/9.80') && preg_match(self::OPERA_VERSION_PATTERN_EXT, $userAgent, $match)) {
            return $match[1];
        }
        if(preg_match(self::OPERA_VERSION_PATTERN, $userAgent, $match)) {
            return $match[1];
        }
        return NULL;
    }

}