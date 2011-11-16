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
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */

use Browscap\Browser\Handler as BrowserHandler;

/**
 * VodafoneUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class Vodafone extends BrowserHandler
{
    protected $prefix = 'VODAFONE';
    
    public function __construct($wurflContext, $userAgentNormalizer = null) 
    {
        parent::__construct($wurflContext, $userAgentNormalizer);
    }
    
    /**
     * Intercepting All User Agents Starting with 'Vodafone'
     *
     * @param $string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        return $this->utils->checkIfStartsWith($userAgent, 'Vodafone');
    }
    
    /** 
     * 
     * @param string $userAgent
     */
    public function lookForMatchingUserAgent($userAgent)
    {    
        $tolerance = $this->utils->ordinalIndexOf($userAgent, '/', 3);        
        return $this->utils->risMatch(array_keys($this->userAgentsWithDeviceID), $userAgent, $tolerance);
    }

}

