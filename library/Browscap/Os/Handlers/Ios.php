<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Os\Handlers;

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

use Browscap\Os\Handler as OsHandler;

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
class Ios extends OsHandler
{
    /**
     * @var string the detected platform
     */
    protected $_name = 'iOS';
    
    /**
     * Returns true if this handler can handle the given $useragent
     *
     * @return bool
     */
    public function canHandle()
    {
        if (!$this->_utils->checkIfContainsAnyOf($this->_useragent, array('IphoneOSX', 'iPhone OS', 'like Mac OS X', 'iPad', 'IPad', 'iPhone', 'iPod'))) {
            return false;
        }
        
        return true;
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @param string $this->_useragent
     *
     * @return string
     */
    protected function _detectVersion()
    {
        $doMatch = preg_match('/IphoneOSX\/([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $matches[1];
            return;
        }
        
        $doMatch = preg_match('/CPU OS ([\d\_]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = str_replace('_', '.', $matches[1]);
            return;
        }
        
        $doMatch = preg_match('/CPU iPad OS ([\d\_]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = str_replace('_', '.', $matches[1]);
            return;
        }
        
        $doMatch = preg_match('/iPhone OS ([\d\_]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = str_replace('_', '.', $matches[1]);
            return;
        }
        
        $doMatch = preg_match('/CPU like Mac OS X/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = '1.0';
            return;
        }
        
        $doMatch = preg_match('/iPhone OS ([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = str_replace('_', '.', $matches[1]);
            return;
        }
        
        $doMatch = preg_match('/iPhone_OS\/([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = str_replace('_', '.', $matches[1]);
            return;
        }
        
        $this->_version = '';
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 404;
    }
}