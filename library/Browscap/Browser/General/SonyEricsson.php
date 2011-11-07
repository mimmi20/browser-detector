<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Browser\General;

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
 * SonyEricssonUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class SonyEricsson extends BrowserHandler
{
    protected $prefix = 'SONY_ERICSSON';
    
    public function __construct($wurflContext, $userAgentNormalizer = null)
    {
        parent::__construct($wurflContext, $userAgentNormalizer);
    }
    
    /**
     * Intercept all UAs containing 'SonyEricsson'
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        return $this->utils->checkIfContains($userAgent, 'SonyEricsson');
    }
    
    /**
     * If UA starts with 'SonyEricsson', apply RIS with FS as a threshold.
     * If UA contains 'SonyEricsson' somewhere in the middle,
     * apply RIS with threshold second slash
     *
     * @param string $userAgent
     * @return string
     */
    public function lookForMatchingUserAgent($userAgent)
    {
        if($this->utils->checkIfStartsWith($userAgent, 'SonyEricsson')) {
            $tollerance = $this->utils->firstSlash($userAgent);
            return $this->utils->risMatch(array_keys($this->userAgentsWithDeviceID), $userAgent, $tollerance);
        }
        $tollerance = $this->utils->secondSlash($userAgent);
        return $this->utils->risMatch(array_keys($this->userAgentsWithDeviceID), $userAgent, $tollerance);
    
    }

}
