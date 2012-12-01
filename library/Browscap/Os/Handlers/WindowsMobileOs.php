<?php
namespace Browscap\Os\Handlers;

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
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */

use Browscap\Os\Handler as OsHandler;

/**
 * MSIEAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */
class WindowsMobileOs extends OsHandler
{
    /**
     * @var string the detected platform
     */
    protected $_name = 'Windows Mobile OS';
    
    /**
     * @var string the manufacturer/creator of this OS
     */
    protected $_manufacturer = 'microsoft';
    
    /**
     * Returns true if this handler can handle the given $useragent
     *
     * @return bool
     */
    public function canHandle()
    {
        if ('' == $this->_useragent) {
            return false;
        }
        
        if ((!$this->_utils->isMobileWindows() 
            && !($this->_utils->isWindows() && $this->_utils->isMobileBrowser()))
            || $this->_utils->checkIfContains(array('Windows Phone OS', 'ZuneWP7', 'XBLWP7'))
        ) {
            return false;
        }
        
        $doMatch = preg_match('/Windows Phone ([\d\.]+)/', $this->_useragent, $matches);
        if ($doMatch && $matches[1] >= 7) {
            return false;
        }
        
        return true;
    }
    
    /**
     * detects the browser name from the given user agent
     *
     * @param string $this->_useragent
     *
     * @return string
     */
    protected function _detectVersion()
    {
        if ($this->_utils->checkIfContains(array('Windows CE', 'Windows Mobile', 'MSIEMobile'))) {
            $doMatch = preg_match('/MSIEMobile ([\d\.]+)/', $this->_useragent, $matches);
            
            if ($doMatch) {
                $this->_version = $matches[1];
                return;
            }
            
            $this->_version = '6.0';
            return;
        }
        
        $doMatch = preg_match('/Windows Phone ([\d\.]+)/', $this->_useragent, $matches);
        if ($doMatch) {
            $this->_version = $matches[1];
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
        return 2;
    }
    
    /**
     * returns null, if the device does not have a specific Browser
     * returns the Browser Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function getBrowser()
    {
        $browsers = array(
            'MicrosoftMobileExplorer',
            'OperaMobile',
            'OperaMini'
        );
        
        $browserPath = realpath(
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' 
            . DIRECTORY_SEPARATOR . 'Browser' 
            . DIRECTORY_SEPARATOR . 'Handlers' . DIRECTORY_SEPARATOR . 'Mobile' 
            . DIRECTORY_SEPARATOR
        );
        $browserNs   = 'Browscap\\Browser\\Handlers\\Mobile';
        
        $chain = new \Browscap\Browser\Chain(false, $browsers, $browserPath, $browserNs);
        $chain->setLogger($this->_logger);
        $chain->setDefaultHandler(new \Browscap\Browser\Handlers\Mobile\MicrosoftMobileExplorer());
        $chain->setUseragent($this->_useragent);
        
        return $chain->detect();
    }
}