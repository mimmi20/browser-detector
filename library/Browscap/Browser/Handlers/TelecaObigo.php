<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Browser\Handlers;

/**
 * Copyright (c) 2012 ScientiaMobile, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or(at your option) any later version.
 *
 * Refer to the COPYING.txt file distributed with this package.
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */

use Browscap\Browser\Handler as BrowserHandler;

/**
 * SonyEricssonUserAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */
class TelecaObigo extends BrowserHandler
{
    /**
     * @var string the detected browser
     */
    protected $_browser = 'Teleca-Obigo';
    
    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        return $this->_utils->checkIfContainsAnyOf($this->_useragent, array('Teleca', 'AU-MIC', 'MIC/', 'Obigo', 'ObigoInternetBrowser'));
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @return string
     */
    protected function _detectVersion()
    {
        $doMatch = preg_match('/MIC\/([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $matches[1];
            return;
        }
        
        $doMatch = preg_match('/ObigoInternetBrowser\/([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $matches[1];
            return;
        }
        
        $doMatch = preg_match('/Obigo Browser ([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $matches[1];
            return;
        }
        
        $doMatch = preg_match('/Obigo\-Browser\/([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $matches[1];
            return;
        }
        
        $doMatch = preg_match('/Teleca\-Obigo ([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $matches[1];
            return;
        }
        
        $doMatch = preg_match('/Obigo\-Q05A\/([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $matches[1];
            return;
        }
        
        $doMatch = preg_match('/TelecaBrowser\/([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $matches[1];
            return;
        }
        
        $doMatch = preg_match('/Teleca\-Q([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = ltrim($matches[1], '0');
            return;
        }
        
        $doMatch = preg_match('/Obigo\-Q([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = ltrim($matches[1], '0');
            return;
        }
        
        $doMatch = preg_match('/Obigo\/Q([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = ltrim($matches[1], '0');
            return;
        }
        
        $doMatch = preg_match('/Teleca\/Q([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = ltrim($matches[1], '0');
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
        return 3;
    }
}
