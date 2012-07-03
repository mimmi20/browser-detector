<?php
namespace Browscap\Device\Handlers\Mobile;

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

use Browscap\Device\Handlers\GeneralMobile;

/**
 * CatchAllUserAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */
class SonyEricsson extends GeneralMobile
{
    /**
     * @var string the detected device
     */
    protected $_device = 'general SonyEricsson';

    /**
     * @var string the detected manufacturer
     */
    protected $_manufacturer = 'SonyEricsson';
    
    /**
     * Final Interceptor: Intercept
     * Everything that has not been trapped by a previous handler
     *
     * @param string $this->_useragent
     * @return boolean always true
     */
    public function canHandle()
    {
        if ('' == $this->_useragent) {
            return false;
        }
        
        $sonyPhones = array(
            'SonyEricsson',
            'Sony',
            'S312',
            'SK17i',
            'SK17iv',
            'ST18i',
            'ST25i',
            'ST25iv',
            'W508a',
            'W760i',
            'WT13i',
            'X1i',
            'X10i',
            'XST2',
            'E15av',
            'E15i'
        );
        
        if ($this->_utils->checkIfContains($sonyPhones)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * detects the device name from the given user agent
     *
     * @param string $userAgent
     *
     * @return StdClass
     */
    public function detect()
    {
        $chain = new \Browscap\Device\Chain(true, null, __DIR__ . DS . 'SonyEricsson' . DS, __NAMESPACE__ . '\\SonyEricsson');
        $chain->setDefaultHandler($this);
        
        return $chain->detect($this->_useragent);
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return parent::getWeight() + 1;
    }
    
    /**
     * returns TRUE if the device has a specific Operating System
     *
     * @return boolean
     */
    public function hasOs()
    {
        return true;
    }
    
    /**
     * returns null, if the device does not have a specific Operating System
     * returns the OS Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function getOs()
    {
        $os = array(
            'Android',
            'Bada',
            'Brew',
            'Java',
            'Symbianos',
            'WindowsMobileOs'
        );
        
        $osChain = new \Browscap\Os\Chain(false, $os);
        $osChain->setLogger($this->_logger);
        
        if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
            $osChain->setCache($this->_cache);
        }
        
        return $osChain->detect($this->_useragent);
    }
    
    /**
     * returns TRUE if the device has a specific Browser
     *
     * @return boolean
     */
    public function hasBrowser()
    {
        return true;
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
            'Android',
            'Chrome',
            'Dalvik',
            'Dolfin',
            'Firefox',
            'Jasmine',
            'MicrosoftMobileExplorer',
            'NetFront',
            'NetFrontLifeBrowser',
            'Openwave',
            'OperaMini',
            'OperaMobile',
            'Polaris',
            'TelecaObigo',
            'Ucweb',
            'WindowsPhoneSearch'
        );
        
        $browserChain = new \Browscap\Browser\Chain(false, $browsers);
        $browserChain->setLogger($this->_logger);
        
        if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
            $browserChain->setCache($this->_cache);
        }
        
        return $browserChain->detect($this->_useragent);
    }
}