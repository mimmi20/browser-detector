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
 * @version   SVN: $Id$
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
 * @version   SVN: $Id$
 */
class Trident extends EngineHandler
{
    /**
     * Intercept all UAs Starting with Mozilla and Containing MSIE and are not mobile browsers
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        if (!$this->utils->checkIfStartsWith($userAgent, 'Mozilla/') 
            && !$this->utils->checkIfContainsAnyOf($userAgent, array('MSIE', 'Trident'))
        ) {
            return false;
        }
        
        if (!$this->utils->checkIfContains($userAgent, 'MSIE')
            && $this->utils->checkIfContainsAnyOf($userAgent, array('KHTML', 'AppleWebKit', 'WebKit', 'Gecko', 'Presto', 'RGAnalytics', 'libwww'))
        ) {
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
        return 'Trident';
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
        
        $doMatch = preg_match('/Trident\/([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        $doMatch = preg_match('/MSIE ([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            $version = '';
            
            switch ((float) $matches[1]) {
                case 10.0:
                    $version = '6.0';
                    break;
                case 9.0:
                    $version = '5.0';
                    break;
                case 8.0:
                case 7.0:
                case 6.0:
                    $version = '4.0';
                    break;
                case 5.5:
                case 5.01:
                case 5.0:
                case 4.01:
                case 4.0:
                case 3.0:
                case 2.0:
                case 1.0:
                default:
                    // do nothing here
            }
            
            return $version;
        }
        
        return '';
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 86837;
    }
}