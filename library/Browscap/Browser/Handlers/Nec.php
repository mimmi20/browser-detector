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
 * NecUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class Nec extends BrowserHandler
{
    public function __construct($wurflContext, $userAgentNormalizer = null)
    {
        parent::__construct($wurflContext, $userAgentNormalizer);
    }
    
    /**
     * Intercept all UAs starting with 'NEC-' and 'KGT'
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        return $this->utils->checkIfStartsWith($userAgent, 'NEC-') || $this->utils->checkIfStartsWith($userAgent, 'KGT');
    }
    
    /**
     * If UA starts with 'NEC', apply RIS of FS
     * If UA starts with KGT, apply LD with threshold 2
     *
     * @param string $userAgent
     * @return boolean
     */
    public function lookForMatchingUserAgent($userAgent)
    {
        if($this->utils->checkIfStartsWith($userAgent, 'NEC-')) {
            $tollerance = $this->utils->firstSlash($userAgent);
            return $this->utils->risMatch(array_keys($this->userAgentsWithDeviceID), $userAgent, $tollerance);
        }
        return $this->utils->ldMatch(array_keys($this->userAgentsWithDeviceID), $userAgent, self::NEC_KGT_TOLLERANCE);
    }
    
    const NEC_KGT_TOLLERANCE = 2;
    protected $prefix = 'NEC';
}
