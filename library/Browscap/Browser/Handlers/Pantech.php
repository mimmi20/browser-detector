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
 * PantechUserAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class Pantech extends BrowserHandler
{
    public function __construct($wurflContext, $userAgentNormalizer = null)
    {
        parent::__construct($wurflContext, $userAgentNormalizer);
    }
    
    /**
     * Intercept all UAs starting with 'Pantech','PANTECH','PT-' or 'PG-'
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        return $this->utils->checkIfStartsWith($userAgent, 'Pantech') || $this->utils->checkIfStartsWith($userAgent, 'PANTECH') || $this->utils->checkIfStartsWith($userAgent, 'PT-') || $this->utils->checkIfStartsWith($userAgent, 'PG-');
    }
    
    /**
     * If starts with 'PT-', 'PG-' or 'PANTECH', use RIS with FS
     * Otherwise LD with threshold 4
     *
     * @param string $userAgent
     * @return string
     */
    public function lookForMatchingUserAgent($userAgent)
    {
        if($this->utils->checkIfStartsWith($userAgent, 'Pantech')) {
            return $this->utils->ldMatch(array_keys($this->userAgentsWithDeviceID), $userAgent, self::PANTECH_TOLLERANCE);
        }
        $tollerance = $this->utils->firstSlash($userAgent);
        return $this->utils->risMatch(array_keys($this->userAgentsWithDeviceID), $userAgent, $tollerance);
    
    }
    
    const PANTECH_TOLLERANCE = 4;
    protected $prefix = 'PANTECH';
}
