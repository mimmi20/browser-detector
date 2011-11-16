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
 * KDDIUserAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class Kddi extends BrowserHandler
{
    protected $prefix = 'KDDI';
    
    public function __construct($wurflContext, $userAgentNormalizer = null)
    {
        parent::__construct($wurflContext, $userAgentNormalizer);
    }
    
    /**
     * Intercept all UAs containing 'KDDI'
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        return $this->utils->checkIfContains($userAgent, 'KDDI');
    }
    
    /**
     */
    public function lookForMatchingUserAgent($userAgent)
    {
        $tolerance = $this->tolerance($userAgent);
        return $this->utils->risMatch(array_keys($this->userAgentsWithDeviceID), $userAgent, $tolerance);
    }
    
    /**
     *
     * @param string $userAgent
     * @return string
     */
    public function applyRecoveryMatch($userAgent)
    {
        if($this->utils->checkIfContains($userAgent, 'Opera')) {
            return 'opera';
        }
        return 'opwv_v62_generic';
    }
    
    private function tolerance($userAgent)
    {
        if($this->utils->checkIfStartsWith($userAgent, 'KDDI/')) {
            return $this->utils->secondSlash($userAgent);
        }
        
        if($this->utils->checkIfStartsWith($userAgent, 'KDDI')) {
            return $this->utils->firstSlash($userAgent);
        }
        
        return $this->utils->indexOfOrLength($userAgent, ')');
    
    }

}
