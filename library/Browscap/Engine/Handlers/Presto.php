<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Engine\Handlers;

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

use Browscap\Engine\Handler as EngineHandler;

/**
 * MSIEAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class Presto extends EngineHandler
{
    /**
     * Intercept all UAs Starting with Mozilla and Containing MSIE and are not mobile browsers
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        if (!$this->utils->checkIfContainsAnyOf($userAgent, array('Presto'))
            && !$this->utils->checkIfContainsAnyOf($userAgent, array('Opera'))
        ) {
            return false;
        }
        
        if ($this->utils->checkIfContainsAnyOf($userAgent, array('KHTML', 'Trident', 'Gecko'))) {
            return false;
        }
        
        return true;
    }
    
    /**
     * detects the browser name from the given user agent
     *
     * @param string $userAgent
     *
     * @return string
     */
    protected function detectEngine($userAgent)
    {
        return 'Presto';
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @param string $userAgent
     *
     * @return string
     */
    protected function detectVersion($userAgent)
    {
        $version = '';
        
        $doMatch = preg_match('/Presto\/([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        return '';
    }
    
    public function getWeight()
    {
        return 1093;
    }
}